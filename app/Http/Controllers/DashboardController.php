<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DashboardController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function index()
    {
        try {
            $kelasResponse = $this->client->request('GET', 'http://localhost:8080/kelas');
            $mahasiswaResponse = $this->client->request('GET', 'http://localhost:8080/mahasiswa');
            
            $kelass = json_decode($kelasResponse->getBody()->getContents(), true);
            $mahasiswas = json_decode($mahasiswaResponse->getBody()->getContents(), true);
            
            $kelasCount = is_array($kelass) ? count($kelass) : 0;
            $mahasiswaCount = is_array($mahasiswas) ? count($mahasiswas) : 0;
            
            return view('dashboard', compact('kelasCount', 'mahasiswaCount', 'kelass', 'mahasiswas'));
        } catch (RequestException $e) {
            return view('dashboard')->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }
}
