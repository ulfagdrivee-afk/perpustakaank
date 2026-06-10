<?php

namespace App\Http\Controllers;
use App\Models\Penerbit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = Penerbit::all();

        return response()->json([
            'message' => 'Get All Penerbit Successful',
            'data' => $penerbit
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_penerbit' => 'required|string|max:4',
            'nama_penerbit' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $penerbit = Penerbit::create([
            'kode_penerbit' => $request->kode_penerbit,
            'nama_penerbit' => $request->nama_penerbit,
        ]);

        return response()->json([
            'message' => 'Create Penerbit Successful', 
            'data' => $penerbit, 
        ], 201);
    }

    public function destroy($id)
    {
          $penerbit = Penerbit::find($id); 
    if (!$penerbit) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Penerbit not found' 
        ], 404); 
    } 
    $penerbit->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Penerbit deleted successful' 
    ], 200); 

    }

    public function update(Request $request)
    {
        $penerbit = Penerbit::find($id); 
        if (!$penerbit) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Penerbit not found' 
            ], 404); 
        } 

           $validator = Validator::make($request->all(), [
              'kode_penerbit' => 'required|string|max:4',
            'nama_penerbit' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors(),
            ], 422);
        }

        $penerbit->update([
            'kode_penerbit' => $request->kode_penerbit,
            'nama_penerbit' => $request->nama_penerbit,
        ]);

        return response()->json([
            'message' => 'Update Penerbit Successful',
            'data' => $penerbit,
        ], 200);
    }
}