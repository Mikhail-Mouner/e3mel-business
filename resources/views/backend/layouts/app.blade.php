<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    @yield('css')
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('admin.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.courses.index') }}">Courses</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    @yield('app')
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    function deleteItem() {
        $('.delete').click(function () {
            let btn = $(this);
            let action = btn.data('action');
            $.post(action,
                {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'DELETE',
                }
            ).done(function (data) {
                btn.parents('tr').html(`<td colspan="6"><h5 class="text-center text-danger">Row deleted successfully</h5></td>`);
            })
        })
    }

    function toTrashItem() {
        $('.to-trash').click(function () {
            let btn = $(this);
            let action = btn.data('action');
            $.post(action,
                {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'DELETE',
                }
            ).done(function (data) {
                btn.parents('tr').html(`<td colspan="6"><h5 class="text-center text-danger">Row is moving to trashed ,Please Refresh Page</h5></td>`);
            })
        })
    }
</script>
@stack('js')
</body>
</html>