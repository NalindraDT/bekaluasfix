@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-gray-700 text-3xl font-medium">Edit prodi</h3>
        <a href="{{ route('prodi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('prodi.update', $prodi['id_prodi']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama prodi</label>
                            <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi', $prodi['nama_prodi']) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nama_prodi') border-red-500 @enderror" required>
                            @error('nama_prodi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="id_prodi" class="block text-sm font-medium text-gray-700">id prodi</label>
                            <input type="text" name="id_prodi" id="id_prodi" value="{{ $prodi['id_prodi'] }}" class="mt-1 bg-gray-100 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                        </div>


                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
