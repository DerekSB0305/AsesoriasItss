<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Materia</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<main class="flex-grow px-4 py-6">

    <div class="w-full max-w-lg mx-auto bg-white shadow-xl rounded-2xl p-6 sm:p-8">

        <a href="{{ route('basic_sciences.subjects.index') }}"
           class="text-[#0B3D7E] hover:text-blue-900 text-sm mb-4 inline-block font-semibold">
            ← Volver a materias
        </a>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6">
            ➕ Registrar Materia
        </h1>

        <form action="{{ route('basic_sciences.subjects.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Nombre de la materia</label>
                <input 
                    type="text" 
                    name="name" 
                    required
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-[#0B3D7E] focus:border-[#0B3D7E] transition"
                >
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tipo (opcional)</label>
                <input type="text" 
                    name="type" 
                    value="{{ old('type') }}"
                    placeholder="Ej. AEG-1060, ABC-2001"
                    class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-[#0B3D7E] transition">
                @error('type')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Carrera</label>
                <select 
                    name="career_id"
                    class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-[#0B3D7E] transition"
                >
                    <option value="">Materia común</option>

                    @foreach($careers as $c)
                        <option value="{{ $c->career_id }}"
                            {{ old('career_id') == $c->career_id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Periodo (opcional)</label>
                <input 
                    type="text" 
                    name="period"
                    value="{{ old('period') }}"
                    placeholder="Ej. INF-2020-203"
                    class="w-full px-4 py-3 border rounded-xl shadow-sm focus:ring-[#0B3D7E] transition"
                >
                @error('period')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button 
                class="w-full py-3 bg-[#28A745] hover:bg-[#1f8a38] text-white font-bold rounded-xl shadow-lg transition">
                Guardar Materia
            </button>

        </form>

    </div>

</main>

<x-basic-sciences-footer />

</body>
</html>
