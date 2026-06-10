<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman_detail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Peminjaman_detailController extends Controller
{
    public function index()
    {
        $peminjaman_detail = Peminjaman_detail::with('peminjaman_id','buku_id')->get();
        $data = $peminjaman_detail->map(function($peminjaman_detail) {
            return [
                'id' => $peminjaman_detail->id,
                'peminjaman_id' => $peminjaman_detail->peminjaman_id,
                'buku_id' => $peminjaman_detail->buku_id,
                'jumlah' => $peminjaman_detail->jumlah,
                'created_at' => $peminjaman_detail->created_at,
                'updated_at' => $peminjaman_detail->updated_at,
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
            'peminjaman_id' => 'required|exists:peminjamans,id',
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

        $peminjaman_detail = Peminjaman_detail::create([
             'peminjaman_id' => $request->peminjaman_id,
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
        ]);

        return response()->json([
            'message' => 'Create  Detail Peminjaman Successful',
            'data' => $pengembalian
        ], 201);
    }

    public function destroy($id)
    {
       $peminjaman_detail = Peminjaman_detail::find($id); 
    if (!$peminjaman_detail) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => ' Detail Peminjaman not found' 
        ], 404); 
    } 
    $peminjaman_detail->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => ' Detail Peminjaman deleted successful' 
    ], 200); 

    
    }

    public function update(Request $request, $id)
    {
           $peminjaman_detail = Pengembalian::find($id); 
        if (!$peminjaman_detail) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => ' Detail Peminjaman not found' 
            ], 404); 
        } 

          $validator = Validator::make($request->all(), [
             'peminjaman_id' => 'required|exists:peminjamans,id',
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
            'message' => 'Update  Detail Peminjaman Successful',
            'data' => $peminjaman_detail
        ], 200);
           
    }
}
