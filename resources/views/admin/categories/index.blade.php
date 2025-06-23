@extends('layouts.admin')

@section('title', 'All Categories')

@section('content')
<div class="container mt-4">
   <div class="headerMenu">
      <!-- Center: Title -->
    <div class="mb-0 text-center">Categories</div>
    <div>
        <!-- Left Side: Back Button -->
    <a href="{{ route('dashboard') }}" class="btn-back">Back</a>
    <a href="{{ route('admin.categories.create') }}" class="add-button">+ Add New Category</a>


    </div>
    <!-- Right Side: Add Button -->
</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped common-datatable">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Desc</th>
                <th class="no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td><img src="{{ asset('storage/' . $category->image) }}" width="50" /></td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->desc }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
