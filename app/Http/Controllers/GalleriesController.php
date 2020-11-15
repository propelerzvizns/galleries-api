<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;

class GalleriesController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $title = $request->get('title', '');
        $description = $request->get('description', '');
        $author = $request->get('author', '');
        $galleries = Gallery::search($title, $description, $author);
        return $galleries;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $validator = Validator::make([
            // $request['title'] => 'required|unique:posts|max:255',
                // 'inputs' => 'required'
                // 'inputs.*.image_url' => 'required'
            // ]);
            // return $validator;
            // $request->validate([$inputs[] => 'required']);

        // return $request->inputs->image_url;
        $validated = $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'nullable|max:1000',
            'inputs' => 'required|array',
            'inputs.*.image_url' => 'required|url'
        ]);
        $user = auth()->user();

        $gallery = Gallery::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);

        // $images = Image::create([
        //     'gallery_id' => $gallery->id,
        //     'image_url' =>
        // ])
        foreach($validated['inputs'] as $image){
            // dd($gallery);
            // return $image['image_url'];
            Image::create([

                'img_url' => $image['image_url'],
                'gallery_id' => $gallery->id
            ]);
        }
        return $gallery->id;
        // return $user->id;
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

        $response = Gallery::with('images', 'user')->findOrFail($id);
        return $response;
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
        //
    }
}
