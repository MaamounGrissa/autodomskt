<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\image;

class imagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::orderBy('created_at', 'desc')->get();
        return view('admin.media', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        set_time_limit(180);
        ini_set('memory_limit', '386M');

        if ($request->hasFile('attachement'))
        {
            $files = $request->file('attachement');
            foreach ($files as $file) {
                $extension = $file->clientExtension();
                if(in_array(strtolower($extension),['jpg','png','gif'])){
                    $fileName = time().'.'. $file->getClientOriginalName();
                    $file->move(public_path('images/admin'), $fileName);
                    $url = public_path('images/admin') . "\\" . $fileName;
                    $image = new image([
                        'filename' => $fileName,
                        'url' => $url,
                    ]);
                    $image->save();
                } else {
                    return redirect()->route('images.index')->with('error', 'Upload Faild');
                }
            } 
            return redirect()->route('images.index')->with('success', 'Upload Done');
        } else {
            return redirect()->route('images.index')->with('error', 'Select Files');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();

        return redirect()->route('images.index')->with('success', 'Image Deleted');
    }
}
