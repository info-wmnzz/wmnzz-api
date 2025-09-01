@extends('layouts.admin')

@section('title', 'Edit ' . ucfirst($setting->key))

@section('content')
<div class="container">
    <h2>Edit {{ ucfirst($setting->key) }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.policy.update', $setting->id) }}">
        @csrf 
        @method('PUT')

        <div class="mb-3">
            <label for="value">Content</label>
            <textarea id="editor" name="value" class="form-control" rows="15">{{ $setting->value }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@section('scripts')
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: 'link lists table code preview',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code preview',
            height: 500
        });
    </script>
@endsection
