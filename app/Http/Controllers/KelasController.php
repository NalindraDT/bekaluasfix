<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KelasController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost:8080/kelas';
    }

    public function index()
    {
        try {
            $response = Http::get($this->baseUrl);
            $kelass = $response->json();

            return view('kelas.index', compact('kelass'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required',
            'nama_kelas' => 'required',
        ]);

        try {
            $response = Http::post($this->baseUrl, [
                'kode_kelas' => $request->kode_kelas,
                'nama_kelas' => $request->nama_kelas,
            ]);

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($kode_kelas)
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$kode_kelas}");
            $kelas = $response->json();
            $kelas = $kelas[0] ?? null;

            if (!$kelas) {
                return back()->with('error', 'Data kelas tidak ditemukan');
            }

            return view('kelas.edit', compact('kelas'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kode_kelas)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        try {
            $response = Http::put("{$this->baseUrl}/{$kode_kelas}", [
                'nama_kelas' => $request->nama_kelas,
                'kode_kelas' => $kode_kelas,
            ]);

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kode_kelas)
    {
        try {
            $response = Http::delete("{$this->baseUrl}/{$kode_kelas}");

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting data: ' . $e->getMessage());
        }
    }
}
