@extends('backend.layouts.app')
@section('title', '| Edit Category ('.$category->name.')')
@section('css')
@endsection

@section('app')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Edit Category ({{ $category->name }})
        </h5>
        <div class="card-body">
            <form action="{{ route('admin.categories.update',$category->id) }}" method="post" autocomplete="off"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   value="{{ old('name',$category->name) }}">
                            @error('name') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select class="form-control" name="active" id="active">
                                <option value="1" {{ $category->active == 1? 'selected':NULL }}>Active</option>
                                <option value="0" {{ $category->active == 0? 'selected':NULL }}>Not Active</option>
                            </select>
                            @error('active') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection