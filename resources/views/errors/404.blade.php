@extends('layouts.main')
@section('title','Page not found')
@section('content')
<div class="container-fluid">
    <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">Looks like we can't find what you're looking for.</p>
        <a href="{{ route('dashboard') }}">&larr; Back to Dashboard</a>
    </div>
</div>
@endsection