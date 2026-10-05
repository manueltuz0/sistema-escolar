<x-app-layout>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6">

            {{-- ENCABEZADO --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Grupo {{ $grupo->nombre }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Información y alumnos pertenecientes al grupo.
                    </p>
                </div>

                <div class="flex gap-2">

                    <a
                        href="{{ route('grupos.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm"
                    >
                        ← Grupos
                    </a>

                    <a
                        href="{{ route('grupos.edit', $grupo) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold"
                    >
                        ✏ Editar grupo
                    </a>

                </div>

            </div>


            {{-- MENSAJE --}}

            @if(session('success'))

                <div class="mb-5 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>

            @endif


            {{-- INFORMACIÓN DEL GRUPO --}}

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                {{-- GRUPO --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                    <p class="text-xs text-gray-500 uppercase font-semibold">
                        Grupo
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $grupo->nombre }}
                    </p>

                </div>


                {{-- GRADO --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                    <p class="text-xs text-gray-500 uppercase font-semibold">
                        Grado
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $grupo->grado }}°
                    </p>

                </div>


                {{-- ALUMNOS --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                    <p class="text-xs text-gray-500 uppercase font-semibold">
                        Alumnos
                    </p>

                    <p class="text-2xl font-bold text-blue-600 mt-2">
                        {{ $grupo->alumnos->count() }}
                    </p>

                </div>


                {{-- CICLO --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">

                    <p class="text-xs text-gray-500 uppercase font-semibold">
                        Ciclo escolar
                    </p>

                    <p class="text-lg font-bold text-gray-800 mt-2">
                        {{ $grupo->cicloEscolar->nombre ?? 'Sin ciclo' }}
                    </p>

                </div>

            </div>


            {{-- INFORMACIÓN ADICIONAL --}}

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>

                        <p class="text-sm text-gray-500">
                            Especialidad
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $grupo->especialidad ?: 'Sin especialidad' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-gray-500">
                            Ciclo escolar
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $grupo->cicloEscolar->nombre ?? 'Sin ciclo escolar' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ALUMNOS DEL GRUPO --}}

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">

                    <div>

                        <h2 class="text-lg font-bold text-gray-800">
                            Alumnos del grupo
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Alumnos actualmente relacionados con este grupo.
                        </p>

                    </div>

                    <span class="text-sm text-gray-500">
                        {{ $grupo->alumnos->count() }} alumno(s)
                    </span>

                </div>


                @if($grupo->alumnos->count())

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-50 border-b border-gray-200">

                                <tr>

                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Matrícula
                                    </th>

                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Alumno
                                    </th>

                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Correo
                                    </th>

                                    <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Acción
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach($grupo->alumnos as $alumno)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                            {{ $alumno->matricula }}
                                        </td>


                                        <td class="px-6 py-4">

                                            <p class="font-semibold text-gray-800">
                                                {{ $alumno->apellidos }}, {{ $alumno->nombres }}
                                            </p>

                                        </td>


                                        <td class="px-6 py-4 text-sm text-gray-500">

                                            {{ $alumno->email ?: 'Sin correo' }}

                                        </td>


                                        <td class="px-6 py-4 text-right">

                                            <a
                                                href="{{ route('alumnos.show', $alumno) }}"
                                                class="inline-block px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-semibold"
                                            >
                                                Ver alumno
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="p-12 text-center">

                        <div class="text-4xl mb-3">
                            👥
                        </div>

                        <h3 class="font-bold text-gray-800">
                            No hay alumnos en este grupo
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Cuando un alumno sea asignado a este grupo aparecerá aquí.
                        </p>

                    </div>

                @endif

            </div>


            {{-- MATERIAS ASIGNADAS --}}

            @if($grupo->asignacionesMaterias->count())

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-6">

                    <div class="px-6 py-5 border-b border-gray-200">

                        <h2 class="text-lg font-bold text-gray-800">
                            Materias asignadas al grupo
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Materias y docentes relacionados con este grupo.
                        </p>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Materia
                                    </th>

                                    <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">
                                        Docente
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">

                                @foreach($grupo->asignacionesMaterias as $asignacion)

                                    <tr>

                                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">

                                            {{ $asignacion->materia->nombre ?? 'Sin materia' }}

                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">

                                            @if($asignacion->docente)

                                                {{ $asignacion->docente->apellidos }},
                                                {{ $asignacion->docente->nombres }}

                                            @else

                                                Sin docente

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif

        </div>
    </div>

</x-app-layout>