<x-app-layout>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-6">

            {{-- ENCABEZADO --}}
            <div class="flex items-center justify-between mb-6">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Registrar grupo
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Registra un nuevo grupo escolar.
                    </p>
                </div>

                <a
                    href="{{ route('grupos.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm"
                >
                    ← Regresar
                </a>

            </div>


            {{-- ERRORES --}}

            @if($errors->any())

                <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">

                    <p class="font-semibold mb-2">
                        Revisa los siguientes campos:
                    </p>

                    <ul class="list-disc ml-5 text-sm">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORMULARIO --}}

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <form
                    action="{{ route('grupos.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- NOMBRE DEL GRUPO --}}

                        <div>

                            <label
                                for="nombre"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre del grupo
                            </label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                placeholder="Ejemplo: A"
                                maxlength="20"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                            <p class="text-xs text-gray-500 mt-1">
                                Ejemplo: A, B, C, D, E o F.
                            </p>

                        </div>


                        {{-- GRADO --}}

                        <div>

                            <label
                                for="grado"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Grado
                            </label>

                            <select
                                id="grado"
                                name="grado"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Seleccionar grado
                                </option>

                                @for($i = 1; $i <= 6; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ old('grado') == $i ? 'selected' : '' }}
                                    >
                                        {{ $i }}° grado
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- ESPECIALIDAD --}}

                        <div class="md:col-span-2">

                            <label
                                for="especialidad"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Especialidad
                            </label>

                            <input
                                type="text"
                                id="especialidad"
                                name="especialidad"
                                value="{{ old('especialidad') }}"
                                placeholder="Ejemplo: Informática"
                                maxlength="100"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                            <p class="text-xs text-gray-500 mt-1">
                                Puedes dejar este campo vacío si el grupo no tiene especialidad.
                            </p>

                        </div>


                        {{-- CICLO ESCOLAR --}}

                        <div class="md:col-span-2">

                            <label
                                for="ciclo_escolar_id"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Ciclo escolar
                            </label>

                            <select
                                id="ciclo_escolar_id"
                                name="ciclo_escolar_id"
                                required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Seleccionar ciclo escolar
                                </option>

                                @foreach($ciclosEscolares as $ciclo)

                                    <option
                                        value="{{ $ciclo->id }}"
                                        {{ old('ciclo_escolar_id') == $ciclo->id ? 'selected' : '' }}
                                    >
                                        {{ $ciclo->nombre }}

                                        @if($ciclo->activo)
                                            — Activo
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- BOTONES --}}

                    <div class="border-t border-gray-200 mt-6 pt-5 flex justify-end gap-3">

                        <a
                            href="{{ route('grupos.index') }}"
                            class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                        >
                            ✓ Guardar grupo
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>