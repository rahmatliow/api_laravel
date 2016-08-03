<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Motor;

use App\warna;

use App\acc;

class model_motor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motor = Motor::paginate(10);
        return Response()->json($motor, 200);
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
        if (is_array($data['id_warna'])) {
            $data['id_warna'] = implode(',', $data['id_warna']);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->savePhoto($request->file('foto'));
        }

        $motor = Motor::create($data);

        if (!$motor) {
            return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    protected function savePhoto(UploadedFile $foto) {
        $filename = str_random(40) . '.' . $foto->guessClientExtension();
        $destinationpath = public_path() . DIRECTORY_SEPARATOR . 'motor';
        $foto->move($destinationpath, $filename);
        return $filename;
    }

    public function deletePhoto($filename) {
        $path = public_path() . DIRECTORY_SEPARATOR . 'motor' . DIRECTORY_SEPARATOR . $filename;
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
        $motor = Motor::find($id);
        return Response()->json($motor, 200);
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
        $motor = Motor::find($id);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->savePhoto($request->file('foto'));
            if ($motor->foto !== '') $this->deletePhoto($motor->foto);

        }

        $success = $motor->update($data);

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
        $motor = Motor::find($id);

        if ($motor->foto !== '') $this->deletePhoto($motor->foto);

        $success = $motor->delete();

        if (!$success) {
            return Response()->json('Failed to delete', 500);
        }

        return Response()->json('success', 200);
    }

    public function get_by_kategori($id)
    {
        $motor_by_kategori = Motor::where('id_kategori',$id)->paginate(10);   
        
        return Response()->json($motor_by_kategori,200);
    }

    public function get_by_warna($id)
    {
        $motor_by_warna = Motor::where('id_warna','LIKE',"%$id%")->paginate(10);   
        
        return Response()->json($motor_by_warna,200);
    }

    public function get_warna($id)
    {
        $motor = Motor::find($id);
        $id_warna = explode(',', $motor->id_warna);
        $warna = Warna::find($id_warna);   
        
        return Response()->json($warna,200);
    }

    public function get_acc($id)
    {
        $acc = Acc::where('id_motor', $id)->get();
        
        return Response()->json($acc,200);
    }
}
