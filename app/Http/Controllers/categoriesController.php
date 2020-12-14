<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\image;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::orderBy('order', 'asc')->get();
        $mainCategories = category::with("image")->where('parent', 0)->orderBy('order', 'asc')->get();
        return view('admin.categories.indexCategories', compact('categories', 'mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainCategories = category::where('parent', 0)->pluck('name', 'id');
        $mainCategories->prepend('None', 0);
        $images = Image::orderBy('created_at', 'desc')->get();
        return view('admin.categories.addCategory', compact('mainCategories', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'order'      => 'required',
        ]);

        $category = new category([
            'name' => $request->get('name'),
            'parent' => $request->get('parent'),
            'order' => $request->get('order'),
            'image_id'  => $request->get('image'),
        ]);

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = category::with('image')->find($id);
        $images = Image::orderBy('created_at', 'desc')->get();
        $mainCategories = category::where('parent', 0)->orderBy('order','asc')->pluck('name', 'id');
        $mainCategories->prepend('None', 0);

        return view('admin.categories.editCategory', compact('category', 'images', 'mainCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'order'      => 'required',
        ]);

        $category = category::find($id);
        $category->name = $request->get('name');
        $category->parent =  $request->get('parent');
        $category->order = $request->get('order');
        $category->image_id = $request->get('image');
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = category::find($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category Deleted!');
    }
}
