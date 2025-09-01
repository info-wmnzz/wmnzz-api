@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="container mt-4">
   <div class="headerMenu">
      <!-- Center: Title -->
    <div class="mb-0 text-center">Settings</div>
    <div>
        <!-- Left Side: Back Button -->
    <a href="{{ route('dashboard') }}" class="btn-back">Back</a>
    </div>
</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped common-datatable">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th class="no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $value)
            <tr>
                <td>{{ $value->key }}</td>
                <td>
                    <a href="{{ route('admin.policy.edit', $value->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
