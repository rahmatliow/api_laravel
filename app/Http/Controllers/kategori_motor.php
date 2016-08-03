<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Kategori;

class kategori_motor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::paginate(10);
        return Response()->json($kategori, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = new Kategori;
        $success = Kategori::create($request->all());

        if(!$success) {
            return Response()->json('Error', 500);
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
        $kategori = Kategori::find($id);
        if (is_null($kategori)) {
            return Response()->json('Not found', 500);
        }

        return Response()->json($kategori, 200);
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
        $kategori = Kategori::find($id);

        if(!is_null($request->get('nama'))) {
            $kategori->nama=$request->get('nama');
        }

        $success = $kategori->save();

        if (!$success) {
            return Response()->json('Error updating', 500);
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
        $kategori = Kategori::find($id);

        if (is_null($kategori)) {
            return Response()->json('Not found', 404);
        }

        $success=$kategori->delete();

        if (!$success) {
            return Response()->json('error deleting', 500);
        }

        return Response()->json('success', 200);
    }
}
