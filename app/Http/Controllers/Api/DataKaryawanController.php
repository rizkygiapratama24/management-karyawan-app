<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DataKaryawanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // set validation
        $validator = Validator::make($request->all(), [
            'id_posisi' => 'required',
            'id_tempat' => 'required',
            'nip' => 'required',
            'nama_karyawan' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'foto' => 'required'
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create user
        $user = new \App\Models\User;
        $user->role = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('karyawan');
        $user->phone_number = $request->phone_number;
        $user->save();

        // upload image
        $foto = $request->file('foto');
        $foto->storeAs('public/images', $foto->hashName());

        // create karyawan
        $karyawan = Karyawan::create([
            'id_user' => $user->id,
            'id_posisi' => $request->id_posisi,
            'id_tempat' => $request->id_tempat,
            'nip' => $request->nip,
            'nama_karyawan' => $request->nama_karyawan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'foto' => $foto->hashName()
        ]);

        if ($request->hasFile('foto')) {
            $request->file('foto')->move('images/', $request->file('foto')->getClientOriginalName());
            $karyawan->foto = $request->file('foto')->getClientOriginalName();
            $karyawan->save();
        }

        // return response JSON karyawan is created
        if ($karyawan) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan Berhasil Disimpan',
                'karyawan' => $karyawan
            ], 201);
        }
    }

    public function get_karyawan($id)
    {
        $karyawan = Karyawan::find($id);
        if ($karyawan) {
            return response()->json([
                'status' => true,
                'karyawan' => $karyawan
            ]);
        }
    }

    public function update_karyawan(Request $request, $id) {
        $user = User::find($request->id_user);
        $karyawan = Karyawan::find($id);

        // Update Karyawan
        $update_karyawan = $karyawan->update([
            'nip' => $request->nip,
            'nama_karyawan' => $request->nama_karyawan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'foto' => $request->foto
        ]);

        // Update User
        $update_user = $user->update([
            'name' => $request->nama_karyawan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role
        ]);

        if ($request->hasFile('foto')) {
            $request->file('foto')->move('images/', $request->file('foto')->getClientOriginalName());
            $karyawan->foto = $request->file('foto')->getClientOriginalName();
            $karyawan->save();
        }

        if ($update_karyawan && $update_user) {
            return response()->json([
                'success' => true,
                'message' => 'Data Karyawan Berhasil Di Edit'
            ]);
        }
    }

    public function delete_karyawan($id) {
        $karyawan = Karyawan::find($id);
        $user = User::find($karyawan->id_user);

        // Hapus Karyawan
        $karyawan->delete();

        // Hapus User
        $user->delete();

        if ($karyawan && $user) {
            return response()->json([
                'success' => true,
                'message' => 'Data Karyawan Berhasil Di Hapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Karyawan Gagal Di Hapus'
            ], 409);
        }
    }
}
