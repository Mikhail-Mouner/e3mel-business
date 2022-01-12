<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{asset('css/front.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
    <a class="navbar-brand ml-2 font-weight-bold" href="#">
        {{ config('app.name') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor"
            aria-controls="navbarColor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor">
        <ul class="navbar-nav">
            <li class="nav-item rounded bg-light search-nav-item  text-center">
                <a class="nav-link" href="{{ route('admin.home') }}">
                    Admin Page
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.home') }}">
                    <span class="fa fa-user-o"></span>
                    <span class="text">Admin</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <span class="fa fa-sign-out"></span>
                    <span class="text">Log out</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
<section id="sidebar">
    <div class="border-bottom pb-2 ml-2">
        <h5 id="burgundy">Filters</h5>
    </div>
    <div class="py-2 border-bottom ml-3" style="height: 250px;overflow-y: scroll">
        <h6 class="font-weight-bold">Categories</h6>
        <form>
            @foreach($categories as $category)
                <div class="form-group">
                    <input class="category" name="category" type="checkbox"
                           value="{{$category->id}}" id="category{{$category->id}}">
                    <label for="artisan">{{$category->name}}</label>
                </div>
            @endforeach
        </form>
    </div>
    <div class="py-2 border-bottom ml-3">
        <h6 class="font-weight-bold">Rating</h6>
        <form>
            @foreach($ratings as $k => $rating)
                <div class="form-group"><input type="radio" class="rating" name="rating" value="{{$k}}" id="choco">
                    @for($stars = 1; $stars <= $k; $stars++)
                        <i class="fa fa-star-o star"></i>
                    @endfor
                    @for($stars = 5; $stars > $k; $stars--)
                        <i class="fa fa-star-o star-empty"></i>
                    @endfor
                </div>
            @endforeach
        </form>
    </div>
    <div class="py-2 ml-3">
        <h6 class="font-weight-bold">Level</h6>
        <form>
            <div class="form-group">
                <input class="levels" type="checkbox" name="level" value="beginner" id="beginner">
                <label for="beginner">Beginner</label>
            </div>
            <div class="form-group">
                <input class="levels" type="checkbox" name="level"
                       value="intermediate" id="intermediate">
                <label for="intermediate">Intermediate</label>
            </div>
            <div class="form-group">
                <input class="levels" type="checkbox" name="level" value="high" id="high">
                <label for="high">High Level</label>
            </div>
        </form>
    </div>
    <div class="py-2 ml-3">
        <h6 class="font-weight-bold">Time</h6>
        <form>
            <div class="form-group">
                <input type="radio" class="time" value="less_4" name="time" id="less_4">
                <label for="less_4">Less Than 4 hrs</label>
            </div>
            <div class="form-group">
                <input type="radio" class="time" value="less_8" name="time" id="less_8">
                <label for="less_8">Less Than 8 hrs</label>
            </div>
            <div class="form-group">
                <input type="radio" class="time" value="more_8" name="time" id="more_8">
                <label for="more_8">More Than 8 hrs</label>
            </div>
        </form>
    </div>
</section>
<section id="products">
    <div class="container">
        <div class="d-flex flex-row">
            <div class="text-muted m-2" id="res">Showing 0 results</div>
        </div>
        <div class="row" id="filter"></div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $("input").on('change', getCourses);
    });
    getCourses();

    function getCourses() {
        var categories = [];
        var ratings = null;
        var levels = [];
        var times = null;
        var search = null;
        $('input:checkbox.category').each(function () {
            if (this.checked) {
                categories.push($(this).val());
            }
        });
        $('input:checkbox.levels').each(function () {
            if (this.checked) {
                levels.push($(this).val());
            }
        });
        $('input:radio.time').each(function () {
            if (this.checked) {
                times = $(this).val();
            }
        });
        $('input:radio.rating').each(function () {
            if (this.checked) {
                ratings = $(this).val();
            }
        });
        $("#search").each(function () {
            search = $(this).val();
        })
        $.ajax({
            url: "{{route('filter')}}",
            data: {categories: categories, levels: levels, times: times, ratings: ratings, search: search},
            success: function (result) {
                $("#filter").html('');
                $("#res").html('');
                var counter = 0;
                $.map(result, val => {
                    counter++;
                    var element = `<div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1" style="padding-bottom: 15px;height: 450px">
                        <div class="card" style="height: 430px">
                            <img class="card-img-top" src="https://images.pexels.com/photos/1775043/pexels-photo-1775043.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500">
                            <div class="card-body" style="height: 150px">
                                <h5><b style="font-family: sans-serif;font-weight: lighter;color: #2FA360">${val.name}</b> </h5>
                                <p class="text-muted text-capitalize">${val.level}</p>
                                <p style="height: 90px">`;
                    element += val.description.substr(0, 90);
                    element += `</p>`;
                    for (var stars = 0; stars < val.rating; stars++) {
                        element += `<span class="fa fa-star" style="color: gold"></span>`
                    }
                    for (var stars = 5; stars > val.rating; stars--) {
                        element += `<span class="fa fa-star-o"></span>`;
                    }
                    element += `<span> (${val.view})</span>
                            </div>
                        </div>
                    </div>`
                    $("#filter").append(element)
                })
                $("#res").html(`Showing ` + counter + ` results`)
            }
        })
    }
</script>
</body>
</html>