<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return response()->json([
            'message' => 'Get All Kategori Successful',
            'data' => $kategori
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kategori' => 'required|string|max:4',
            'nama_kategori' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategori = Kategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'message' => 'Create Kategori Successful', 
            'data' => $kategori, 
        ], 201);
    }

    public function destroy($id)
    {
          $kategori = Kategori::find($id); 
    if (!$kategori) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Kategori not found' 
        ], 404); 
    } 
    $kategori->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Kategori deleted successful' 
    ], 200); 

    }

    public function update(Request $request)
    {
        $kategori = Kategori::find($id); 
        if (!$kategori) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Kategori not found' 
            ], 404); 
        } 

           $validator = Validator::make($request->all(), [
            'kode_kategori' => 'required|string|max:4',
            'nama_kategori' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'message' => 'Update Kategori Successful',
            'data' => $kategori,
        ], 200);
    }
}