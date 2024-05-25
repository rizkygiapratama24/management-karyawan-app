<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataTempatController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'kode_tempat' => 'required',
            'nama_tempat' => 'required'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create posisi
        $tempat = Tempat::create([
            'kode_tempat' => $request->kode_tempat,
            'nama_tempat' => $request->nama_tempat
        ]);

        // return response JSON posisi is created
        if ($tempat) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Tempat Berhasil Disimpan'
            ], 201);
        }

        // return JSON process insert failed
        return response()->json([
            'success' => false
        ], 409);
    }

    public function get_tempat($id) {
        $tempat = Tempat::find($id);
        return response()->json([
            'status' => true,
            'tempat' => $tempat
        ]);
    }

    public function update_tempat(Request $request, $id) {
        $tempat = Tempat::find($id);

        // update tempat
        $tempat->update([
            'kode_tempat' => $request->kode_tempat,
            'nama_tempat' => $request->nama_tempat
        ]);

        if ($tempat) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Tempat Berhasil Di Edit',
                'tempat' => $tempat
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function delete_tempat($id) {
        $tempat = Tempat::find($id);
        $tempat->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Tempat Berhasil Di Hapus',
            'tempat' => $tempat
        ], 201);
    }
}
