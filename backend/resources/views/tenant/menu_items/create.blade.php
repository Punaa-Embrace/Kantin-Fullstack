@extends('layouts.app')
@section('title', 'Tambah Menu Baru')
@section('header', 'Tambah Menu Baru')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
    <form action="{{ route('tenant.menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('tenant.menu_items._form')
        <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-300">
            <a href="{{ route('tenant.menu-items.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Simpan</button>
        </div>
    </form>
</div>
@endsection