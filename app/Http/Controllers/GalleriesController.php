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
    public function getAuthorGalleries($id, Request $request){
        $title = $request->get('title', '');
        $galleries = Gallery::searchByAuthor($id, $title);
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

            // return $data;
        $validated = $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'nullable|max:1000',
            'images' => 'required|array',
            'images.*.img_url' => 'required|url'
        ]);
        $user = $request->user_id;

        $gallery = Gallery::create([
            'user_id' => $user,
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);


        foreach($validated['images'] as $image){
            Image::create([

                'img_url' => $image['img_url'],
                'gallery_id' => $gallery->id
            ]);
        }
        return $request;
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
        // return $request;
        $gallery = Gallery::findOrFail($id);
        // return $request->galleryToEdit;
        // $galleryToEdit = $request['galleryToEdit'];
        $validated = $request->validate([
            'galleryToEdit.title' => 'required|min:2|max:255',
            'galleryToEdit.description' => 'nullable|max:1000',
            'galleryToEdit.images' => 'required|array',
            'galleryToEdit.images.*.img_url' => 'required|url',
            'galleryToEdit.user_id' => 'numeric'

        ]);

        $gallery->update($validated["galleryToEdit"]);

        foreach($validated["galleryToEdit"]['images'] as $imageV){
            $image = Image::findOrFail($imageV["id"]);
            $image->update($imageV);
        }
        foreach($request["inputsToDelete"] as $imageD){
            $image = Image::findOrFail($imageD["id"]);
            $image->delete();
        }
        return $request;
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
