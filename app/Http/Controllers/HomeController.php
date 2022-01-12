<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::Active()->get();
        $courses = Course::select( 'rating' )->get();
        $ratings = collect( $courses )->groupBy( 'rating' );

        return view( 'home', compact( [ 'categories', 'ratings' ] ) );
    }

    public function filter(Request $request)
    {
        $categories = $request->categories;
        $levels = $request->levels;
        $ratings = $request->ratings;
        $times = $request->times;

        return Course::ActiveCategory()
            ->Active()
            ->when( $categories, function ($q) use ($categories) {
                return $q->whereIn( 'category_id', $categories );
            } )
            ->when( $levels, function ($q) use ($levels) {
                return $q->whereIn( 'level', $levels );
            } )
            ->when( $ratings, function ($q) use ($ratings) {
                return $q->whereRating( $ratings );
            } )
            ->when( $times, function ($q) use ($times) {
                if ($times == 'less_4') {
                    return $q->where( 'hours', '<', 4 );
                } elseif ($times == 'less_8') {
                    return $q->where( 'hours', '<', 8 );
                } elseif ($times == 'more_8') {
                    return $q->where( 'hours', '>=', 8 );
                }
            } )->get();
    }

}
