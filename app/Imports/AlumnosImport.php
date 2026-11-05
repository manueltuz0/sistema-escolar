<?php

namespace App\Imports;

use App\Models\Alumno;
use App\Models\Grupo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnosImport implements ToCollection, WithHeadingRow
{
    public int $importados = 0;

    public array $errores = [];

    public function collection(Collection $rows): void
    {
        // Obtener los grupos existentes para no buscarlos en cada fila.
        $grupos = Grupo::all()->keyBy(function ($grupo) {
            return $grupo->grado . '|' . mb_strtolower(trim($grupo->nombre));
        });

        // Consultar matrículas y correos existentes.
        $matriculas = Alumno::pluck('matricula')
            ->map(fn ($valor) => mb_strtolower(trim($valor)))
            ->flip()
            ->all();

        $correos = Alumno::pluck('email')
            ->map(fn ($valor) => mb_strtolower(trim($valor)))
            ->flip()
            ->all();

        foreach ($rows as $indice => $fila) {
            $numeroFila = $indice + 2;

            $matricula = trim((string) ($fila['matricula'] ?? ''));
            $nombres = trim((string) ($fila['nombres'] ?? ''));
            $apellidos = trim((string) ($fila['apellidos'] ?? ''));
            $email = mb_strtolower(trim((string) ($fila['email'] ?? '')));
            $grado = trim((string) ($fila['grado'] ?? ''));
            $nombreGrupo = trim((string) ($fila['grupo'] ?? ''));

            // Ignorar filas completamente vacías.
            if (
                $matricula === '' &&
                $nombres === '' &&
                $apellidos === '' &&
                $email === '' &&
                $grado === '' &&
                $nombreGrupo === ''
            ) {
                continue;
            }

            $datos = [
                'matricula' => $matricula,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'email' => $email,
                'grado' => $grado,
                'grupo' => $nombreGrupo,
            ];

            $validador = Validator::make($datos, [
                'matricula' => ['required', 'string', 'max:20'],
                'nombres' => ['required', 'string', 'max:100'],
                'apellidos' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'max:150'],
                'grado' => ['required', 'integer', 'min:1', 'max:12'],
                'grupo' => ['required', 'string', 'max:20'],
            ]);

            if ($validador->fails()) {
                $this->errores[] = "Fila {$numeroFila}: " .
                    implode(' ', $validador->errors()->all());
                continue;
            }

            $claveGrupo = ((int) $grado) . '|' . mb_strtolower($nombreGrupo);
            $grupo = $grupos->get($claveGrupo);

            if (!$grupo) {
                $this->errores[] =
                    "Fila {$numeroFila}: no existe el grupo {$grado} {$nombreGrupo}.";
                continue;
            }

            $matriculaClave = mb_strtolower($matricula);

            if (isset($matriculas[$matriculaClave])) {
                $this->errores[] =
                    "Fila {$numeroFila}: la matrícula {$matricula} ya existe o está repetida.";
                continue;
            }

            $correoClave = mb_strtolower($email);

            if (isset($correos[$correoClave])) {
                $this->errores[] =
                    "Fila {$numeroFila}: el correo {$email} ya existe o está repetido.";
                continue;
            }

            try {
                Alumno::create([
                    'matricula' => $matricula,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'grupo_id' => $grupo->id,
                ]);

                // Registrar inmediatamente para detectar duplicados dentro del mismo Excel.
                $matriculas[$matriculaClave] = true;
                $correos[$correoClave] = true;
                $this->importados++;
            } catch (\Throwable $e) {
                $this->errores[] =
                    "Fila {$numeroFila}: no se pudo guardar el alumno. " .
                    $e->getMessage();
            }
        }
    }
}
