<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
        $categories = Category::all();

        return view( 'backend.pages.courses.index', compact( 'categories' ) );
    }

    public function create()
    {
        $categories = Category::all();

        return view( 'backend.pages.courses.create', compact( 'categories' ) );
    }

    public function store(CourseRequest $request)
    {
        Course::create( [
            'name' => $request->name,
            'description' => $request->description,
            'level' => $request->level,
            'hours' => $request->hours,
            'active' => $request->active,
            'category_id' => $request->category_id,
        ] );

        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );

        return redirect()->route( 'admin.courses.index' );
    }

    public function show($id)
    {
    }

    public function edit(Course $course)
    {
        $categories = Category::all();

        return view( 'backend.pages.courses.edit', compact( [ 'course', 'categories' ] ) );
    }

    public function update(CourseRequest $request, Course $course)
    {
        $course->update( [
            'name' => $request->name,
            'description' => $request->description,
            'level' => $request->level,
            'hours' => $request->hours,
            'active' => $request->active,
            'category_id' => $request->category_id,
        ] );

        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Updated Data Successfully' ] );

        return redirect()->route( 'admin.courses.index' );
    }

    public function destroy($id)
    {
        $course = Course::withTrashed()->find( $id );
        if ($course->trashed()) {
            $course->forceDelete();
        } else {
            $course->delete();
        }

        return TRUE;
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->find( $id );
        if ($course) {
            $course->restore();
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Restored Data Successfully' ] );
        } else {
            session()->flash( 'mssg', [ 'status' => 'warning', 'data' => 'Something Goes wrong!' ] );
        }

        return redirect()->route( 'admin.courses.index' );
    }

}
