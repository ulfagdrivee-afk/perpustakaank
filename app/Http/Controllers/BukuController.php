<?php

namespace App\Http\Controllers;
use App\Models\Buku;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori','penerbit')->get();
        $data = $buku->map(function($buku) {
            return [
                'id' => $buku->id,
                'kode_buku' => $buku->kode_buku,
                'judul' => $buku->judul,
                // 'kategori_id' => $buku->kategori_id,
                'kategori_name' => $buku->kategori->nama_kategori ?? null,
                // 'penerbit_id' => $buku->penerbit_id,
                'penerbit_name' => $buku->penerbit->nama_penerbit ?? null,
                'isbn' => $buku->isbn,
                'pengarang' => $buku->pengarang,
                'jumlah_halaman' => $buku->jumlah_halaman,
                'jumlah_stok' => $buku->jumlah_stok,
                'tahun_terbit' => $buku->tahun_terbit,
                'sinopsis' => $buku->sinopsis,
                'gambar' => $buku->gambar,
                'created_at' => $buku->created_at,
                'updated_at' => $buku->updated_at,
            ];
    });

    return response()->json([
        'message' => 'Get All Buku Successful',
        'data' => $data
    ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_buku' => 'required|string|max:10',
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penerbit_id' => 'required|exists:penerbits,id',
            'isbn' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'jumlah_stok' => 'required|integer|min:1',
            'tahun_terbit' => 'required|integer|min:1',
            'sinopsis' => 'required|string',
             'gambar' => 'required|image|mimes:jpeg,png,jpg|max:100000',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }

        $buku = Buku::create([
              'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penerbit_id' => $request->penerbit_id,
            'isbn' => $request->isbn,
            'pengarang' => $request->pengarang,
            'jumlah_halaman' => $request->jumlah_halaman,
            'jumlah_stok' => $request->jumlah_stok,
            'tahun_terbit' => $request->tahun_terbit,
            'sinopsis' => $request->sinopsis,
            'gambar' => $request->gambar,
        ]);
    if ($request->hasFile('gambar')) { 
        $file = $request->file('gambar')->store('images', 'public'); 

        return response()->json([
            'message' => 'Create Buku Successful',
            'data' => $buku
        ], 201);
    }
    }
    public function destroy($id)
    {
       $buku = Buku::find($id); 
    if (!$buku) { 
        return response()->json([ 
            'status' => 'Error', 
            'message' => 'Buku not found' 
        ], 404); 
    } 
    $buku->delete(); 
    return response()->json([ 
        'status' => 'success', 
        'message' => 'Buku deleted successful' 
    ], 200); 

    
    }

    public function update(Request $request, $id)
    {
           $buku = Buku::find($id); 
        if (!$buku) { 
            return response()->json([ 
                'status' => 'error', 
                'message' => 'Buku not found' 
            ], 404); 
        } 

          $validator = Validator::make($request->all(), [
                'kode_buku' => 'required|string|max:10',
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'penerbit_id' => 'required|exists:penerbits,id',
            'isbn' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'jumlah_halaman' => 'required|integer|min:1',
            'jumlah_stok' => 'required|integer|min:1',
            'tahun_terbit' => 'required|integer|min:1',
            'sinopsis' => 'required|string',
             'gambar' => 'required|image|mimes:jpeg,png,jpg|max:100000',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }
        $buku->update([
               'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'penerbit_id' => $request->penerbit_id,
            'isbn' => $request->isbn,
            'pengarang' => $request->pengarang,
            'jumlah_halaman' => $request->jumlah_halaman,
            'jumlah_stok' => $request->jumlah_stok,
            'tahun_terbit' => $request->tahun_terbit,
            'sinopsis' => $request->sinopsis,
            'gambar' => $request->gambar,
        ]);
        if ($request->hasFile('gambar')) { 
            if ($buku->gambar) { 
                Storage::disk('public')->delete($buku->gambar); 
            } 
            $file = $request->file('gambar')->store('images', 'public'); 
            $data['gambar'] = $file; 
        } 

        return response()->json([
            'message' => 'Update Buku Successful',
            'data' => $buku
        ], 200);
           
    }
}