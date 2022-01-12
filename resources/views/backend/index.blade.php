@extends('backend.layouts.app')
@section('title', '| Admin Page')

@section('app')
    <div class="card">
        <div class="card-header">Home</div>
        <div class="card-body">
            <nav class="nav nav-pills justify-content-center">
                <a class="nav-link btn-lg" href="{{ route('admin.categories.index') }}">Categories</a>
                <a class="nav-link active btn-lg" href="{{ route('home') }}">Home</a>
                <a class="nav-link btn-lg" href="{{ route('admin.courses.index') }}">Courses</a>
            </nav>
        </div>
    </div>

@endsection

