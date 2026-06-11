<?php

namespace App\Http\Controllers;
use App\Models\Anggota;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();

        return response()->json([
            'message' => 'Get All Anggota Successful',
            'data' => $anggota
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_anggota' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string|max:12',
            'alamat' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $anggota = Anggota::create([
           'kode_anggota' => $request->kode_anggota,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'foto' => $request->foto,
        ]);
        if ($request->hasFile('foto')) { 
        $file = $request->file('foto')->store('images', 'public'); 
        return response()->json([
            'message' => 'Create Anggota Successful', 
            'data' => $anggota, 
        ], 201);
    }
    }
    public function destroy($id)
    {
          $anggota = Anggota::find($id); 
    if (!$anggota) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Anggota not found' 
        ], 404); 
    } 
    $anggota->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Anggota deleted successful' 
    ], 200); 

    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::find($id); 
        if (!$anggota) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Anggota not found' 
            ], 404); 
        } 

           $validator = Validator::make($request->all(), [
             'kode_anggota' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string|max:12',
            'alamat' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $anggota->update([
            'kode_anggota' => $request->kode_anggota,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'foto' => $request->foto,
        ]);
          if ($request->hasFile('foto')) { 
            if ($anggota->foto) { 
                Storage::disk('public')->delete($anggota->foto); 
            } 
            $file = $request->file('foto')->store('images', 'public'); 
            $data['foto'] = $file; 
        } 
        return response()->json([
            'message' => 'Update Anggota Successful',
            'data' => $anggota,
        ], 200);
    }
}