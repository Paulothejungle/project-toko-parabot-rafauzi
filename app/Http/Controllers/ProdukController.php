<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::with('kategori')->paginate(10);
        $kategori = Kategori::all();

        return view('produk.index', compact('produk','kategori'));
    }


    public function create()
    {
        $kategori = Kategori::all();

        return view('produk.create', compact('kategori'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk','deskripsi','harga','stok','kategori_id']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produk','public');
        }

        Produk::create($data);

        return redirect('/produk')
            ->with('success','Produk berhasil ditambahkan');
    }


    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('produk.edit', compact('produk','kategori'));
    }


    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk','deskripsi','harga','stok','kategori_id']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                Storage::disk('public')->delete($produk->image);
            }
            $data['image'] = $request->file('image')->store('produk','public');
        }

        $produk->update($data);

        return redirect('/produk')
            ->with('success','Produk berhasil diupdate');
    }


    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->detailPesanan()->count() > 0) {
            return redirect('/produk')
                ->with('error','Produk tidak bisa dihapus karena sudah ada transaksi');
        }

        // Hapus gambar dari storage jika ada
        if ($produk->image && Storage::disk('public')->exists($produk->image)) {
            Storage::disk('public')->delete($produk->image);
        }

        $produk->delete();

        return redirect('/produk')
            ->with('success','Produk berhasil dihapus');
    }

}