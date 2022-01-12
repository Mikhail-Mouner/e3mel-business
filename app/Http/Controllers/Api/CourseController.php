<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::Active()->ActiveCategory()->with( 'category' )->get();

        return CourseResource::collection( $courses );
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::wherehas( 'category' )->with( 'category' )
                ->when( $request->category_id, function ($instance) use ($request) {
                    $instance->where( 'category_id', $request->category_id );
                } )
                ->withTrashed()->latest()->get();

            return DataTables::of( $data )
                ->addIndexColumn()
                ->editColumn( 'description', function ($row) {
                    return '<span title="' . $row->description . '">' . Str::words( $row->description, 5 ) . '</span>';
                } )
                ->editColumn( 'active',
                    '{!! $active?"<span class=\"badge badge-success w-100 \">Active</span>":"<span class=\"badge badge-danger w-100 \">Not Active</span>" !!}' )
                ->addColumn( 'details', function ($row) {
                    return
                        '<span class="text-muted fw-bold">rating</span>: <span>' . $row->rating . '</span><br />'
                        . '<span class="text-muted fw-bold">view</span>: <span>' . $row->view . '</span><br />'
                        . '<span class="text-muted fw-bold">level</span>: <span>' . $row->level . '</span><br />'
                        . '<span class="text-muted fw-bold">hours</span>: <span>' . $row->hours . '</span><br />';
                } )
                ->addColumn( 'category_name', function ($row) {
                    return '<span class="badge badge-secondary w-100">' . $row->category->name . '</span>';
                } )
                ->addColumn( 'trashed', function ($row) {
                    return $row->trashed() ? '<span class="badge badge-warning w-100">trashed</span>' : '-';
                } )
                ->addColumn( 'action', function ($row) {
                    if (!$row->trashed()) {
                        $actionBtn = '<a href="' . route( 'admin.courses.edit',
                                $row->id ) . '" class="edit btn btn-success btn-sm">Edit</a>';
                        $actionBtn .= '<a href="#" data-action="' . route( 'admin.courses.destroy',
                                $row->id ) . '" class="to-trash btn btn-danger btn-sm">Delete</a>';
                    } else {
                        $actionBtn = '<a href="' . route( 'admin.courses.restore',
                                $row->id ) . '" class="edit btn btn-outline-success btn-sm">Restore</a>';
                        $actionBtn .= '<a href="#" data-action="' . route( 'admin.courses.destroy',
                                $row->id ) . '" class="delete btn btn-outline-danger btn-sm">Force Delete</a>';
                    }

                    return $actionBtn;
                } )
                ->rawColumns( [ 'description', 'details', 'active', 'trashed', 'category_name', 'action' ] )
                ->make( TRUE );
        }
    }

}
