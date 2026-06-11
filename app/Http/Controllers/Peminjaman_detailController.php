<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman_detail;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Peminjaman_detailController extends Controller
{
    public function index()
    {
        $peminjaman_detail = Peminjaman_detail::with('peminjaman', 'buku')->get();
        $data = $peminjaman_detail->map(function($detail) {
            return [
                'id' => $detail->id,
                'peminjaman_id' => $detail->peminjaman_id,
                'buku_id' => $detail->buku_id,
                'judul_buku' => $detail->buku->judul ?? null, 
                'jumlah' => $detail->jumlah,
                'created_at' => $detail->created_at,
                'updated_at' => $detail->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Get All Detail Peminjaman Successful',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }
        $buku = Buku::find($request->buku_id);
        $peminjaman = Peminjaman::find($request->peminjaman_id);
        if ($peminjaman->status === 'dipinjam') {
            if ($buku->jumlah_stok < $request->jumlah) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Stok buku tidak cukup!'
                ], 400);
            }
            $buku->jumlah_stok -= $request->jumlah;
        } else {
            $buku->jumlah_stok += $request->jumlah;
        }
        $buku->save();
        $peminjaman_detail = Peminjaman_detail::create([
            'peminjaman_id' => $request->peminjaman_id,
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
        ]);

        return response()->json([
            'message' => 'Create Detail Peminjaman Successful',
            'data' => $peminjaman_detail
        ], 201);
    }

    public function destroy($id)
    {
        $peminjaman_detail = Peminjaman_detail::find($id); 
        if (!$peminjaman_detail) { 
            return response()->json([ 
                'status' => 'Error', 
                'message' => 'Detail Peminjaman not found' 
            ], 404); 
        } 
        
        return response()->json([ 
            'status' => 'success', 
            'message' => 'Detail Peminjaman deleted successful' 
        ], 200); 
    }

    public function update(Request $request, $id)
    {
        $peminjaman_detail = Peminjaman_detail::find($id); 
        if (!$peminjaman_detail) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Detail Peminjaman not found' 
            ], 404); 
        } 

        $validator = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }

        $peminjaman_detail->update([
            'peminjaman_id' => $request->peminjaman_id,
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
        ]);

        return response()->json([
            'message' => 'Update Detail Peminjaman Successful',
            'data' => $peminjaman_detail
        ], 200);
    }
}