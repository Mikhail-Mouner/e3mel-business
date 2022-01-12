@extends('backend.layouts.app')
@section('title', '| Add New Course')
@section('css')
@endsection

@section('app')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Add New Course
        </h5>
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="post" autocomplete="off"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @error('name') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="active">Active</label>
                            <select class="form-control" name="active" id="active">
                                <option value="1" {{ old('active') == 1? 'selected':'' }}>Active</option>
                                <option value="0" {{ old('active') == 0? 'selected':'' }}>Not Active</option>
                            </select>
                            @error('active') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hours">hours</label>
                            <input type="number" class="form-control" name="hours" id="hours"
                                   value="{{ old('hours') }}">
                            @error('hours') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="0" selected hidden>select Category</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id') == $item->id? 'selected':'' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="form-control" name="level" id="level">
                                <option value="beginner" {{ old('level') == 'beginner'? 'selected':'' }}>Beginner
                                </option>
                                <option value="immediate" {{ old('level') == 'immediate'? 'selected':'' }}>Immediate
                                </option>
                                <option value="high" {{ old('level') == 'high'? 'selected':'' }}>High</option>
                            </select>
                            @error('level') <small class="form-text text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description') <small class="form-text text-danger">{{ $message }}</small> @enderror
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