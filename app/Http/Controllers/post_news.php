<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\post;

class post_news extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::paginate(10);
        return Response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();


        if ($request->hasFile('foto')) {
            $data['foto'] = $this->savePhoto($request->file('foto'));
        }

        $post = Post::create($data);

        if (!$post) {
            return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    protected function savePhoto(UploadedFile $foto) {
        $filename = str_random(40) . '.' . $foto->guessClientExtension();
        $destinationpath = public_path() . DIRECTORY_SEPARATOR . 'news';
        $foto->move($destinationpath, $filename);
        return $filename;
    }

    public function deletePhoto($filename) {
        $path = public_path() . DIRECTORY_SEPARATOR . 'news' . DIRECTORY_SEPARATOR . $filename;
        return File::delete($path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return Response()->json($post, 200);
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
        $post = Post::find($id);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->savePhoto($request->file('foto'));
            if ($post->foto !== '') $this->deletePhoto($post->foto);

        }

        $success = $post->update($data);

        if (!$success) {
            return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post->foto !== '') $this->deletePhoto($post->foto);

        $success = $post->delete();

        if (!$success) {
            return Response()->json('Failed to delete', 500);
        }

        return Response()->json('success', 200);
    }
}
