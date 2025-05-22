<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdiController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost:8080/prodi';
    }

    public function index()
    {
        try {
            $response = Http::get($this->baseUrl);
            $prodiss = $response->json();

            return view('prodi.index', compact('prodiss'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('prodi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        try {
            $response = Http::asForm()->post($this->baseUrl, [
                'id_prodi' => $request->id_prodi,
                'nama_prodi' => $request->nama_prodi,
            ]);

            return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id_prodi)
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$id_prodi}");
            $prodi = $response->json();
            $prodi = $prodi[0] ?? null;

            if (!$prodi) {
                return back()->with('error', 'Data prodi tidak ditemukan');
            }

            return view('prodi.edit', compact('prodi'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id_prodi)
    {
        $request->validate([
            'nama_prodi' => 'required',
        ]);

        try {
            $response = Http::put("{$this->baseUrl}/{$id_prodi}", [
                'id_prodi' => $id_prodi,
                'nama_prodi' => $request->nama_prodi,
            ]);

            return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id_prodi)
    {
        try {
            $response = Http::delete("{$this->baseUrl}/{$id_prodi}");

            return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting data: ' . $e->getMessage());
        }
    }
}
