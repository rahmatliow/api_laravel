<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Merk;

class merk_motor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merk = Merk::paginate(10);
        return Response()->json($merk, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'nama' => 'required',
        	'photo' => 'mimes:jpeg,png|max:10240'
        ]);

        $data = $request->only('nama');

        if ($request->hasFile('logo')) {
        	//print_r($request->file('logo'));exit;
        	$data['logo'] = $this->savePhoto($request->file('logo'));
        }

        $merk = Merk::create($data);

        if (!$merk) {
        	return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    protected function savePhoto(UploadedFile $logo) {
    	$filename = str_random(40) . '.' . $logo->guessClientExtension();
    	$destinationpath = public_path() . DIRECTORY_SEPARATOR . 'merk';
    	$logo->move($destinationpath, $filename);
    	return $filename;
    }

    public function deletePhoto($filename) {
    	$path = public_path() . DIRECTORY_SEPARATOR . 'merk' . DIRECTORY_SEPARATOR . $filename;
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
        $merk = Merk::find($id);
        return Response()->json($merk, 200);
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
    	$merk = Merk::find($id);

        $this->validate($request, [
        	'nama' => 'required',
        	'logo' => 'mimes:jpeg,png|max:10240'
        ]);

        $data = $request->only('nama');

        if ($request->hasFile('logo')) {
        	$data['logo'] = $this->savePhoto($request->file('logo'));
        	if ($merk->logo !== '') $this->deletePhoto($merk->logo);

        }

        $success = $merk->update($data);

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
        $merk = Merk::find($id);

       	if ($merk->logo !== '') $this->deletePhoto($merk->logo);

        $success = $merk->delete();

        if (!$success) {
        	return Response()->json('Failed to delete', 500);
        }

        return Response()->json('success', 200);
    }
}
