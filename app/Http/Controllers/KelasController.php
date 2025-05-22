<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class KelasController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:8080/kelas';
    }

    public function index()
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl);
            $kelass = json_decode($response->getBody()->getContents(), true);

            return view('kelas.index', compact('kelass'));
        } catch (RequestException $e) {
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
            $response = $this->client->request('POST', $this->baseUrl, [
                'json' => [
                    'kode_kelas' => $request->kode_kelas,
                    'nama_kelas' => $request->nama_kelas,
                ]
            ]);

            return redirect()->route('kelas.index')->with('success', 'kelas berhasil ditambahkan');
        } catch (RequestException $e) {
            return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($kode_kelas)
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl . '/' . $kode_kelas);
            $kelas = json_decode($response->getBody()->getContents(), true);
            // Ambil data dari indeks 0
            $kelas = $kelas[0] ?? null;
            if (!$kelas) {
                return back()->with('error', 'Data kelas tidak ditemukan');
            }
            return view('kelas.edit', compact('kelas'));
        } catch (RequestException $e) {
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $kode_kelas)
    {
        $request->validate([
            'nama_kelas' => 'required',
        ]);

        try {
            $response = $this->client->request('PUT', $this->baseUrl . '/' . $kode_kelas, [
                'json' => [
                    'nama_kelas' => $request->nama_kelas,
                    'kode_kelas' => $kode_kelas,
                ]
            ]);

            return redirect()->route('kelas.index')->with('success', 'kelas berhasil diperbarui');
        } catch (RequestException $e) {
            return back()->with('error', 'Error updating data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($kode_kelas)
    {
        try {
            $response = $this->client->request('DELETE', $this->baseUrl . '/' . $kode_kelas);

            return redirect()->route('kelas.index')->with('success', 'kelas berhasil dihapus');
        } catch (RequestException $e) {
            return back()->with('error', 'Error deleting data: ' . $e->getMessage());
        }
    }
}
