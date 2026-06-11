<?php

namespace App\Http\Controllers;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('user','peminjaman')->get();
        $data = $pengembalian->map(function($pengembalian) {
            return [
                'id' => $pengembalian->id,
                'peminjaman_id' => $pengembalian->peminjaman_id,
                'tanggal_kembali' => $pengembalian->tanggal_kembali,
                'user_id' => $pengembalian->user_id,
                'created_at' => $pengembalian->created_at,
                'updated_at' => $pengembalian->updated_at,
            ];
    });

    return response()->json([
        'message' => 'Get All Pengembalian Successful',
        'data' => $data
    ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengembalian = Pengembalian::create([
              'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Create Pengembalian Successful',
            'data' => $pengembalian
        ], 201);
    }

    public function destroy($id)
    {
       $pengembalian = Pengembalian::find($id); 
    if (!$pengembalian) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Peminjaman not found' 
        ], 404); 
    } 
    $pengembalian->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Peminjaman deleted successful' 
    ], 200); 

    
    }

    public function update(Request $request, $id)
    {
           $pengembalian = Pengembalian::find($id); 
        if (!$pengembalian) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Peminjaman not found' 
            ], 404); 
        } 

          $validator = Validator::make($request->all(), [
             'peminjaman_id' => 'required|exists:peminjamen,id',
            'tanggal_kembali' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }
        $pengembalian->update([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'user_id' => auth()->id(),

        ]);

        return response()->json([
            'message' => 'Update Peminjaman Successful',
            'data' => $pengembalian
        ], 200);
           
    }
}