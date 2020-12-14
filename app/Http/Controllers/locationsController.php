<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\location;

class locationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = location::orderBy('order', 'asc')->get();
        $states = location::where('state', 0)->orderBy('order', 'asc')->get();
        return view('admin.locations.indexLocations', compact('locations', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = location::where('state', 0)->pluck('name', 'id');
        $states->prepend('None', 0);
        return view('admin.locations.addLocation', compact('states'));
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
            'state'      => 'required',
            'order'      => 'required',
        ]);

        $location = new location([
            'name' => $request->get('name'),
            'state' => $request->get('state'),
            'order' => $request->get('order'),
        ]);

        $location->save();

        return redirect()->route('locations.index')->with('success', 'Location Added!');
   
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
        $location = location::find($id);
        $states = location::where('state', 0)->orderBy('order','asc')->pluck('name', 'id');
        $states->prepend('None', 0);

        return view('admin.locations.editLocation', compact('location', 'states'));
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
            'state'      => 'required',
            'order'      => 'required',
        ]);

        $location = location::find($id);
        $location->name = $request->get('name');
        $location->state =  $request->get('state');
        $location->order = $request->get('order');
        $location->save();

        return redirect()->route('locations.index')->with('success', 'Location Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = location::find($id);
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Location Deleted!');
    }
}
