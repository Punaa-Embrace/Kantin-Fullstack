@extends('layouts.app')

@section('title', 'Edit Stand')
@section('header', 'Edit Stand: ' . $tenant->name)

@section('content')
<div class="container mx-auto">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Edit Stand</h2>
        <form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.tenants._form')
            <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-300">
                <a href="{{ route('admin.tenants.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection