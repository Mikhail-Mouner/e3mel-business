@extends('backend.layouts.app')
@section('title', '| Courses')
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('app')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Courses
            <a href="{{ route('admin.courses.create') }}">
                <button type="button" class="btn btn-sm btn-primary">
                    Add New
                </button>
            </a>
        </h5>
        <div class="card-body">
            @include('includes._alert')

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="category"><strong>Category :</strong></label>
                        <select id='category' class="form-control">
                            <option value="0" selected>select Category</option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="col-md-12">
                <div class="col-md-12">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>description</th>
                            <th>details</th>
                            <th>Category</th>
                            <th>Trashed</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </hr>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endpush
@method("DELETE")
@push('js')
    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('courses.list') }}",
                    data: function (d) {
                        d.category_id = $('#category').val()
                    }
                },
                initComplete: function () {
                    deleteItem();
                    toTrashItem();
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',},
                    {data: 'name', name: 'name'},
                    {data: 'active', name: 'active'},
                    {data: 'description', name: 'description'},
                    {data: 'details', name: 'details'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'trashed', name: 'trashed'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#category').change(function(){
                table.draw();
            });
        });
    </script>
@endpush