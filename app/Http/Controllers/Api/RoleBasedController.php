<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role_Based;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleBasedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'akses_tambah' => 'required',
            'akses_edit' => 'required',
            'akses_hapus' => 'required'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create role_based
        $role_based = Role_Based::create([
            'id_user' => $request->id_user,
            'akses_tambah' => $request->akses_tambah,
            'akses_edit' => $request->akses_edit,
            'akses_hapus' => $request->akses_hapus
        ]);

        // return response JSON posisi is created
        if ($role_based) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role Based Berhasil Di Setting',
                'role_based' => $role_based
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function get_role($id) {
        $role = Role_Based::find($id);
        return response()->json([
            'success' => true,
            'role' => $role
        ]);
    }

    public function update_role(Request $request, $id) {
        $role = Role_Based::find($id);
        $role->update($request->all());

        if ($role) {
            return response()->json([
                'status' => 'success',
                'message' => 'Role Berhasil Di Edit',
                'role' => $role
            ], 201);
        }

         // return JSON process insert failed
         return response()->json([
            'success' => false,
        ], 409);
    }

    public function delete_role($id) {
        $role = Role_Based::find($id);
        $role->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Role Berhasil Di Hapus',
            'role' => $role
        ], 201);
    }
}
