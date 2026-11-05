<?php

namespace App\Imports;

use App\Models\Docente;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DocentesImport implements ToCollection, WithHeadingRow
{
    public int $importados = 0;

    public array $errores = [];

    public function collection(Collection $rows): void
    {
        // Obtener los números de empleado y correos ya registrados.
        $numerosEmpleado = Docente::pluck('numero_empleado')
            ->map(fn ($valor) => mb_strtolower(trim($valor)))
            ->flip()
            ->all();

        $correos = Docente::pluck('email')
            ->map(fn ($valor) => mb_strtolower(trim($valor)))
            ->flip()
            ->all();

        foreach ($rows as $indice => $fila) {
            $numeroFila = $indice + 2;

            $numeroEmpleado = trim(
                (string) ($fila['numero_empleado'] ?? '')
            );

            $nombres = trim((string) ($fila['nombres'] ?? ''));
            $apellidos = trim((string) ($fila['apellidos'] ?? ''));

            $email = mb_strtolower(
                trim((string) ($fila['email'] ?? ''))
            );

            $telefono = trim((string) ($fila['telefono'] ?? ''));
            $especialidad = trim(
                (string) ($fila['especialidad'] ?? '')
            );

            // Ignorar filas completamente vacías.
            if (
                $numeroEmpleado === '' &&
                $nombres === '' &&
                $apellidos === '' &&
                $email === '' &&
                $telefono === '' &&
                $especialidad === ''
            ) {
                continue;
            }

            $datos = [
                'numero_empleado' => $numeroEmpleado,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'email' => $email,
                'telefono' => $telefono !== '' ? $telefono : null,
                'especialidad' => $especialidad !== ''
                    ? $especialidad
                    : null,
            ];

            $validador = Validator::make($datos, [
                'numero_empleado' => [
                    'required',
                    'string',
                    'max:20',
                ],
                'nombres' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'apellidos' => [
                    'required',
                    'string',
                    'max:150',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:150',
                ],
                'telefono' => [
                    'nullable',
                    'string',
                    'max:20',
                ],
                'especialidad' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
            ]);

            if ($validador->fails()) {
                $this->errores[] = "Fila {$numeroFila}: " .
                    implode(' ', $validador->errors()->all());

                continue;
            }

            $numeroClave = mb_strtolower($numeroEmpleado);

            if (isset($numerosEmpleado[$numeroClave])) {
                $this->errores[] =
                    "Fila {$numeroFila}: el número de empleado " .
                    "{$numeroEmpleado} ya existe o está repetido.";

                continue;
            }

            $correoClave = mb_strtolower($email);

            if (isset($correos[$correoClave])) {
                $this->errores[] =
                    "Fila {$numeroFila}: el correo {$email} " .
                    "ya existe o está repetido.";

                continue;
            }

            try {
                Docente::create($datos);

                // Evitar duplicados dentro del mismo archivo.
                $numerosEmpleado[$numeroClave] = true;
                $correos[$correoClave] = true;

                $this->importados++;
            } catch (\Throwable $e) {
                report($e);

                $this->errores[] =
                    "Fila {$numeroFila}: no se pudo guardar el docente. " .
                    "Revisa los datos de esa fila.";
            }
        }
    }
}