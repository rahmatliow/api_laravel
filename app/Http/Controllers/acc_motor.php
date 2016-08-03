<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\acc;

class acc_motor extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acc = Acc::paginate(10);
        return Response()->json($acc, 200);
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

        $acc = Acc::create($data);

        if (!$acc) {
        	return Response()->json('Failed to save', 500);
        }

        return Response()->json('success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acc = Acc::Find($id);
        return Response()->json($acc, 200);
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
        $acc = Acc::find($id);

        $data = $request->all();

        $success = $acc->update($data);

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
        $acc = Acc::find($id);

        $success = $acc->delete();

        if (!$success) {
        	return Response()->json('Failed to delete', 500);
        }

        return Response()->json('success', 200);
    }
}
