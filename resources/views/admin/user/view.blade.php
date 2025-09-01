@extends('layouts.admin')

@section('title', 'All Users')

@section('content')
<div class="container mt-4">
   <div class="headerMenu">
      <!-- Center: Title -->
    <div class="mb-0 text-center">Customer View</div>
    <div>
        <!-- Left Side: Back Button -->
    <a href="" class="btn-back">Back</a>

    </div>
    <!-- Right Side: Add Button -->
</div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped common-datatable">
        
    </table>
</div>
@endsection
