@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen p-8 text-white">
    <h3 class="text-4xl font-bold mb-8">📊 Dashboard</h3>

    <div class="flex flex-wrap gap-6">
        <!-- Kartu Dosen -->
        <div class="w-full sm:w-1/2 xl:w-1/3 bg-gray-800 rounded-lg shadow-lg p-6 flex items-center hover:shadow-xl transition duration-300">
            <div class="p-4 bg-indigo-600 rounded-full">
                <i class="fas fa-user-tie text-white text-3xl"></i>
            </div>
            <div class="ml-5">
                <h4 class="text-3xl font-bold text-white">{{ $dosenCount ?? 0 }}</h4>
                <div class="text-gray-400">Dosen</div>
            </div>
        </div>

        <!-- Kartu Mahasiswa -->
        <div class="w-full sm:w-1/2 xl:w-1/3 bg-gray-800 rounded-lg shadow-lg p-6 flex items-center hover:shadow-xl transition duration-300">
            <div class="p-4 bg-green-600 rounded-full">
                <i class="fas fa-user-graduate text-white text-3xl"></i>
            </div>
            <div class="ml-5">
                <h4 class="text-3xl font-bold text-white">{{ $mahasiswaCount ?? 0 }}</h4>
                <div class="text-gray-400">Mahasiswa</div>
            </div>
        </div>
    </div>
</div>
@endsection
