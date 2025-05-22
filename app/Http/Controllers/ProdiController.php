<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ProdiController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:8080/prodi';
    }

    public function index()
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl);
            $prodiss = json_decode($response->getBody()->getContents(), true);

            return view('prodi.index', compact('prodiss'));
        } catch (RequestException $e) {
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
            $response = $this->client->request('POST', $this->baseUrl, [
                'json' => [
                    'nama_prodi' => $request->nama_prodi,
                    'id_prodi' => $request->id_prodi,
                ]
            ]);

            return redirect()->route('prodi.index')->with('success', 'prodi berhasil ditambahkan');
        } catch (RequestException $e) {
            return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id_prodi)
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl . '/' . $id_prodi);
            $prodi = json_decode($response->getBody()->getContents(), true);
            // Ambil data dari indeks 0
            $prodi = $prodi[0] ?? null;
            if (!$prodi) {
                return back()->with('error', 'Data prodi tidak ditemukan');
            }
            return view('prodi.edit', compact('prodi'));
        } catch (RequestException $e) {
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id_prodi)
    {
        $request->validate([
            'nama_prodi' => 'required',
        ]);

        try {
            $response = $this->client->request('PUT', $this->baseUrl . '/' . $id_prodi, [
                'json' => [
                    'nama_prodi' => $request->nama_prodi,
                    'id_prodi' => $id_prodi,
                ]
            ]);

            return redirect()->route('prodi.index')->with('success', 'prodi berhasil diperbarui');
        } catch (RequestException $e) {
            return back()->with('error', 'Error updating data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id_prodi)
    {
        try {
            $response = $this->client->request('DELETE', $this->baseUrl . '/' . $id_prodi);

            return redirect()->route('prodi.index')->with('success', 'prodi berhasil dihapus');
        } catch (RequestException $e) {
            return back()->with('error', 'Error deleting data: ' . $e->getMessage());
        }
    }
}
