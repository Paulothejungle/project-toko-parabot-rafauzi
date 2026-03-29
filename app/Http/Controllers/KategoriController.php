<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
                         ->with('success','Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')
                         ->with('success','Kategori berhasil diupdate');
    }

    public function destroy($id)
    {

    $kategori = Kategori::findOrFail($id);

    if($kategori->produk()->count() > 0){

    return redirect('/kategori')
    ->with('error',
    'Kategori tidak bisa dihapus karena masih digunakan produk');

    }

    $kategori->delete();

    return redirect('/kategori')
    ->with('success',
    'Kategori berhasil dihapus');

    }
}