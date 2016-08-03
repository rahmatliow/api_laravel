<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Warna;

class warna_motor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warna = Warna::paginate(10);
        return Response()->json($warna, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $warna = new Warna;
        $success = Warna::create($request->all());

        if(!$success) {
            return Response()->json('Error', 200);
        } else {
            return Response()->json('success', 200);
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
        $warna = Warna::find($id);
        if (is_null($warna)) {
            return Response()->json('Not found', 500);
        }

        return Response()->json($warna, 200);
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
        $warna = Warna::find($id);

        if(!is_null($request->get('nama'))) {
            $warna->nama=$request->get('nama');
        }

        $success = $warna->save();

        if (!$success) {
            return Response()->json('Error updating', 200);
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
        $warna = Warna::find($id);

        if (is_null($warna)) {
            return Response()->json('Not found', 404);
        }

        $success=$warna->delete();

        if (!$success) {
            return Response()->json('error deleting', 500);
        }

        return Response()->json('success', 200);
    }
}
