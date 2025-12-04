@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Categories
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Edit Category</h2>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Category <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $category->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    <strong>Current Slug:</strong> {{ $category->slug }}
                </p>
                <p class="text-sm text-gray-500">Slug akan diupdate otomatis saat nama diubah</p>
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition"
                >
                    Update
                </button>
                <a 
                    href="{{ route('admin.categories.index') }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
