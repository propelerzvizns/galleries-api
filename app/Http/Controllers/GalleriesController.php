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
        $validated = $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'nullable|max:1000',
            'images' => 'required|array',
            'images.*.img_url' => 'required|url',
            'user_id' => 'numeric'
        ]);
        $user = $request->user_id;

        foreach($validated['images'] as $imageV){
            $gallery_id = $imageV['gallery_id'];
            $images = Image::where('gallery_id', $gallery_id)->get();
            foreach($images as $image){
                // return $imageV['gallery_id'];
                if($image->gallery_id === $imageV['gallery_id']){

                    $gallery->update($imageV);
                } else {
                        // $imagedelete = Image::findOrFail($imageId);
                    $image->delete();
                }
            }
            // return $images;
            // $imageGalleyId = $imageV['gallery_id'];
            // $imageId =  $imageV['id'];
            // if($imageGalleyId === $imageId){
            //     // return 'true';
            //     $image = Image::findOrFail($imageId);

            //     $image->update($imageV);
            // }
            // else {
            //     // return 'false';

            //     $image->delete();

            // }
            // return $imageV['id'];
            // $image = Image::findOrFail($id);
            // return $image;
        }

        return $validated;
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
