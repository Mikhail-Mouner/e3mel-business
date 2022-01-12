@extends('backend.layouts.app')
@section('title', '| Categories')
@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('app')
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Categories
            <a href="{{ route('admin.categories.create') }}">
                <button type="button" class="btn btn-sm btn-primary">
                    Add New
                </button>
            </a>
        </h5>
        <div class="card-body">
            @include('includes._alert')
            <table class="table table-bordered yajra-datatable">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Total Of Courses <br /> (Active + Not Active)</th>
                    <th>Trashed</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endpush
@push('js')
    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.list') }}",
                initComplete: function () {
                    deleteItem();
                    toTrashItem();
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex',},
                    {data: 'name', name: 'name'},
                    {data: 'active', name: 'active'},
                    {data: 'courses_count', name: 'courses_count'},
                    {data: 'trashed', name: 'trashed'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

        });
    </script>
@endpush