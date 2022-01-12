<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view( 'backend.pages.categories.index' );
    }

    public function create()
    {
        return view( 'backend.pages.categories.create' );
    }

    public function store(CategoryRequest $request)
    {
        Category::create( [
            'name' => $request->name,
            'active' => $request->active,
            'slug' => Str::slug( $request->name ),
        ] );

        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );

        return redirect()->route( 'admin.categories.index' );
    }

    public function show($id)
    {
    }

    public function edit(Category $category)
    {
        return view( 'backend.pages.categories.edit', compact( 'category' ) );
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update( [
            'name' => $request->name,
            'active' => $request->active,
            'slug' => Str::slug( $request->name ),
        ] );

        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Updated Data Successfully' ] );

        return redirect()->route( 'admin.categories.index' );
    }

    public function destroy($id)
    {
        $category = Category::withTrashed()->find( $id );
        if ($category->trashed()) {
            $category->forceDelete();
        } else {
            $category->delete();
        }

        return TRUE;
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->find( $id );
        if ($category) {
            $category->restore();
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Restored Data Successfully' ] );
        } else {
            session()->flash( 'mssg', [ 'status' => 'warning', 'data' => 'Something Goes wrong!' ] );
        }

        return redirect()->route( 'admin.categories.index' );
    }

}
