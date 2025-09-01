@extends('layouts.admin')

@section('title', 'All Users')

@section('content')
<div class="container mt-4">
   <div class="headerMenu">
      <!-- Center: Title -->
    <div class="mb-0 text-center">Customer</div>
    <div>
        <!-- Left Side: Back Button -->
    <a href="{{ route('dashboard') }}" class="btn-back">Back</a>
    <!-- <a href="{{ route('admin.categories.create') }}" class="add-button">+ Add New value</a> -->


    </div>
    <!-- Right Side: Add Button -->
</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped common-datatable">
        <thead class="table-dark">
            <tr>
                <th>Customer Id</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th class="no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customer as $value)
            <tr>
                <td>{{ $value->cus_id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->mobile }}</td>
                <td>{{ $value->email }}</td>
                <td>
                    <!-- <a href="{{ route('admin.users.edit', $value->id) }}" class="btn btn-sm btn-secondary">Edit</a> -->

                    <form action="{{ route('admin.users.destroy', $value->id) }}"
                        method="POST"
                        class="d-inline-block"
                        onsubmit="return confirm('Delete this?')">
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
