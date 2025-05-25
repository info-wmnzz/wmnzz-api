@extends('layouts.admin')

@section('title', 'All Banners')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-banner.css') }}">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">All Banners</h2>
        <a href="{{ route('admin.banner.create') }}" class="add-button">+ Add Banner</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle shadow-sm border">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Preview</th>
                    <th scope="col">Title</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($banners as $banner)
                    <tr>
                        <td class="text-center">{{ $banner->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner Image" height="50" style="border-radius: 4px;">
                        </td>
                        <td>{{ $banner->title }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-primary me-1">Edit</a>

                            <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No banners found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
