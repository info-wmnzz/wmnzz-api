@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Add New Category</h4>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="form_wmn">
        @csrf

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}" required>
        </div>

        <div class="mb-3">
            <label>Category Description</label>
            <textarea name="category_description" class="form-control">{{ old('category_description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category Type</label>
            <input type="text" name="category_type" class="form-control" value="{{ old('category_type') }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" onchange="previewImage(event)">
            <img id="preview" class="mt-2" style="max-width: 150px; display:none;">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary-wmn">Save</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mx-2">Cancel</a>
        </div>
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
