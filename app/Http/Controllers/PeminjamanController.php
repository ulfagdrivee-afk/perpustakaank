<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user_id','anggota_id')->get();
        $data = $peminjaman->map(function($peminjaman) {
            return [
                'id' => $peminjaman->id,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'lama_pinjam' => $peminjaman->lama_pinjam,
                'keterangan' => $peminjaman->keterangan,
                'status' => $peminjaman->status,
                'anggota_id' => $peminjaman->anggota_id,
                'user_id' => $peminjaman->user_id,
                  'created_at' => $peminjaman->created_at,
                'updated_at' => $peminjaman->updated_at,
            ];
    });

    return response()->json([
        'message' => 'Get All Peminjaman Successful',
        'data' => $data
    ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
            'keterangan' => 'required|string',
            'status' => 'required|in:dipinjam, sudah dikembalikan',
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }

        $peminjaman = Peminjaman::create([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'lama_pinjam' => $request->lama_pinjam,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'user_id' =>Auth()->id(),
            'anggota_id' => $request->anggota_id,
        ]);

        return response()->json([
            'message' => 'Create Peminjaman Successful',
            'data' => $peminjaman
        ], 201);
    }

    public function destroy($id)
    {
       $peminjaman = Peminjaman::find($id); 
    if (!$peminjaman) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Peminjaman not found' 
        ], 404); 
    } 
    $peminjaman->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Peminjaman deleted successful' 
    ], 200); 

    
    }

    public function update(Request $request, $id)
    {
           $peminjaman = Peminjaman::find($id); 
        if (!$peminjaman) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Peminjaman not found' 
            ], 404); 
        } 

          $validator = Validator::make($request->all(), [
            'tanggal_pinjam' => 'required|date',
            'lama_pinjam' => 'required|integer|min:1',
            'keterangan' => 'required|string',
            'status' => 'required|in:dipinjam, sudah dikembalikan',
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }
        $peminjaman->update([
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'lama_pinjam' => $request->lama_pinjam,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'user_id' =>Auth()->id(),
            'anggota_id' => $request->anggota_id,

        ]);

        return response()->json([
            'message' => 'Update Peminjaman Successful',
            'data' => $peminjaman
        ], 200);
           
    }
}
