<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataPosisiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'kode_posisi' => 'required',
            'nama_posisi' => 'required|unique:data_posisi'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create posisi
        $posisi = Posisi::create([
            'kode_posisi' => $request->kode_posisi,
            'nama_posisi' => $request->nama_posisi
        ]);

        // return response JSON posisi is created
        if ($posisi) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Posisi Berhasil Disimpan',
                'posisi' => $posisi
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function data_posisi()
    {
        $posisi = Posisi::all();
        return response()->json([
            'status' => true,
            'posisi' => $posisi
        ], 201);
    }

    public function get_posisi($id)
    {
        $posisi = Posisi::find($id);
        return response()->json([
            'status' => true,
            'posisi' => $posisi
        ], 201);
    }

    public function update_posisi(Request $request, $id)
    {
        $posisi = Posisi::find($id);

        // update posisi
        $posisi->update([
            'kode_posisi' => $request->kode_posisi,
            'nama_posisi' => $request->nama_posisi
        ]);

        if ($posisi) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Posisi Berhasil Di Edit',
                'posisi' => $posisi
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function delete_posisi($id)
    {
        $posisi = Posisi::find($id);
        $posisi->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Posisi Berhasil Di Hapus',
            'posisi' => $posisi
        ], 201);
    }
}
