<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\event;

class post_event extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event = Event::paginate(10);
        return Response()->json($event, 200);
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

        $event = Event::create($data);

        if (!$event) {
            return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    protected function savePhoto(UploadedFile $foto) {
        $filename = str_random(40) . '.' . $foto->guessClientExtension();
        $destinationpath = public_path() . DIRECTORY_SEPARATOR . 'event';
        $foto->move($destinationpath, $filename);
        return $filename;
    }

    public function deletePhoto($filename) {
        $path = public_path() . DIRECTORY_SEPARATOR . 'event' . DIRECTORY_SEPARATOR . $filename;
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
        $event = Event::find($id);
        return Response()->json($event, 200);
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
        $event = Event::find($id);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->savePhoto($request->file('foto'));
            if ($event->foto !== '') $this->deletePhoto($event->foto);

        }

        $success = $event->update($data);

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
        $event = Event::find($id);

        if ($event->foto !== '') $this->deletePhoto($event->foto);

        $success = $event->delete();

        if (!$success) {
            return Response()->json('Failed to delete', 500);
        }

        return Response()->json('success', 200);
    }
}
