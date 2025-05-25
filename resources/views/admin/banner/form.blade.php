@extends('layouts.admin')
@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-banner.css') }}">
<div class="banner-form-wrapper">
    <a href="{{ route('admin.banner.index') }}" class="back-button">← Back to All Banners</a>

    <h2>{{ isset($banner) ? 'Edit' : 'Add' }} Banner</h2>

    <form 
        action="{{ isset($banner) ? route('admin.banner.update', $banner->id) : route('admin.banner.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="banner-form"
    >
        @csrf
        @if(isset($banner))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Banner Image</label>
            <input type="file" name="image" id="imageInput" {{ isset($banner) ? '' : 'required' }} onchange="previewImage(event)">
            <div class="preview">
                <img id="preview" src="{{ isset($banner) && $banner->image ? asset('storage/' . $banner->image) : '' }}" alt="" style="max-height: 200px; margin-top: 15px;">
            </div>
        </div>

        <button type="submit" class="btn-submit">{{ isset($banner) ? 'Update' : 'Create' }}</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const output = document.getElementById('preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = () => URL.revokeObjectURL(output.src);
    }
</script>
@endsection

