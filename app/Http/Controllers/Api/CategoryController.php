<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::Active()->get();

        return CategoryResource::collection( $categories );
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::withCount( 'courses' )->withTrashed()->latest()->get();

            return DataTables::of( $data )
                ->addIndexColumn()
                ->editColumn( 'active',
                    '{!! $active?"<span class=\"badge badge-success w-100 \">Active</span>":"<span class=\"badge badge-danger w-100 \">Not Active</span>" !!}' )
                ->editColumn( 'courses_count',
                    '<span class="badge badge-secondary w-100">{{$courses_count}} Courses</span>' )
                ->addColumn( 'trashed', function ($row) {
                    return $row->trashed() ? '<span class="badge badge-warning w-100">trashed</span>' : '-';
                } )
                ->addColumn( 'action', function ($row) {
                    if (!$row->trashed()) {
                        $actionBtn = '<a href="' . route( 'admin.categories.edit',
                                $row->id ) . '" class="edit btn btn-success btn-sm">Edit</a>';
                        $actionBtn .= '<a href="#" data-action="' . route( 'admin.categories.destroy',
                                $row->id ) . '" class="to-trash btn btn-danger btn-sm">Delete</a>';
                    } else {
                        $actionBtn = '<a href="' . route( 'admin.categories.restore',
                                $row->id ) . '" class="edit btn btn-outline-success btn-sm">Restore</a>';
                        $actionBtn .= '<a href="#" data-action="' . route( 'admin.categories.destroy',
                                $row->id ) . '" class="delete btn btn-outline-danger btn-sm">Force Delete</a>';
                    }

                    return $actionBtn;
                } )
                ->rawColumns( [ 'active', 'trashed', 'courses_count', 'action' ] )
                ->make( TRUE );
        }
    }

}
