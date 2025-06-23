@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="container mt-4">
    <h2>Edit Category</h2>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name', $category->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Category Description</label>
            <textarea name="category_description" class="form-control">{{ old('category_description', $category->desc) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category Type</label>
            <input type="text" name="category_type" class="form-control" value="{{ old('category_type', $category->category_type) }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="2" {{ old('status', $category->status) == 2 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" onchange="previewImage(event)">
            @if($category->image)
                <img id="preview" src="{{ asset('storage/' . $category->image) }}" class="mt-2" style="max-width: 150px;">
            @else
                <img id="preview" class="mt-2" style="max-width: 150px; display:none;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
