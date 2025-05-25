@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('content')
<div class="container">
    <h2>Edit Banner</h2>
    <form method="POST" action="{{ route('admin.banner.update', $banner->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $banner->title }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <br>
            <img src="{{ asset('storage/' . $banner->image) }}" height="100">
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
