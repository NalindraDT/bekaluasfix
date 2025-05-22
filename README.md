# LANGKAH LANGKAH MENGUBAH

## syntax mysql

```
CREATE TABLE kelas (
kode_kelas VARCHAR(10) PRIMARY KEY,
nama_kelas VARCHAR(50) NOT NULL);

CREATE TABLE prodi (
    id_prodi INT AUTO_INCREMENT PRIMARY KEY,
    nama_prodi VARCHAR(100) NOT NULL
);

INSERT INTO kelas (kode_kelas, nama_kelas) VALUES
('KLS01', 'TI A'),
('KLS02', 'TM B'),
('KLS03', 'MM A'),
('KLS04', 'AK A'),
('KLS05', 'TE A');

INSERT INTO prodi (id_prodi, nama_prodi) VALUES
(1, 'Teknik Informatika'),
(2, 'Teknik Mesin'),
(3, 'Multimedia'),
(4, 'Akuntansi'),
(5, 'Teknik Elektro');

```

## LARAVEL

### 1. Buka terminal lalu lalu ketik
``` PS C:\laragon\www> laravel new (nama projek)```
### 2. Pilih none
```
 Which starter kit would you like to install? [None]:
  [none    ] None
  [react   ] React
  [vue     ] Vue
  [livewire] Livewire
 > none
 ```

### 3. Pilih 1 untuk php
```
Which testing framework do you prefer? [Pest]:
  [0] Pest
  [1] PHPUnit
 > 1
```
### 4. Pilih mysql
```
Which database will your application use? [SQLite]:
  [sqlite ] SQLite
  [mysql  ] MySQL
  [mariadb] MariaDB
  [pgsql  ] PostgreSQL (Missing PDO extension)
  [sqlsrv ] SQL Server (Missing PDO extension)
 > mysql
```
### 5. Pilih no untuk migrations
```
Default database updated. Would you like to run the default database migrations? (yes/no) [yes]:
 > no
 ```

### 6. Pilih yes untuk menginstall npm
```
Would you like to run npm install and npm run build? (yes/no) [yes]:
 > yes
```

### 7. Ketik ini
```
PS C:\laragon\www> cd {nama projek}
```
### 8. lalu ketik
```
code .
```

### 9. Pergi ke .env pada vs code laravel lalu atur seperti ini

```
SESSION_DRIVER=file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=

```


## ENDPOINT

```
Kelas

GET http://localhost:8080/kelas
POST http://localhost:8080/kelas/{id kelas}
DEL http://localhost:8080/kelas/{id kelas}
PUT http://localhost:8080/kelas/{id kelas}

Prodi

GET http://localhost:8080/prodi
POST http://localhost:8080/prodi/{id prodi}
DEL http://localhost:8080/prodi/{id prodi}
PUT http://localhost:8080/prodi/{id prodi}
```
## BACK END
### 1. Ambil clone back end
dengan cara 

``` 
git clone https://github.com/NalindraDT/bekaluasfix.git
```


## FRONT END

### 1. Ambil data dari repo front end
dengan cara 

``` git clone https://github.com/NalindraDT/bekaluasfix.git```

### 2. Masukan sesuai directory nya
isi folder frontend : controller, view, route

### 3. buka folder controller front end github

app -> http -> controllers -> (dalam sini)

### 4. buka folder resources

resources -> views -> dalam sini

### 5. buka folder routes
routes -> disini

## ERROR handeling

### 1. kalau muncul error 'View [kelas.index] not found.' ganti nama folder/cari 
### 2. Kalau muncul error di compact maka variable salah
contoh
Jika pada controller ada seperti ini
```php
public function index()
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl);
            $mahasiswa = json_decode($response->getBody()->getContents(), true);
            
            return view('mahasiswa.index', compact('mahasiswas'));
        } catch (RequestException $e) {
            return back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }
```
maka error biasanya terjadi karena variable $mahasiswa dalam try harus sama dengan compact yang $mahasiswa
harusnya -> try = $mahasiswa dan compact = $mahasiswa

### 3. Kalau muncul error " Undefined array key "kode_kelas" "
dan kode edit di controller seperti ini

```php
 public function edit($kode_kelas)
    {
        try {
            $response = $this->client->request('GET', $this->baseUrl . '/' . $kode_kelas);
            $kelas = json_decode($response->getBody()->getContents(), true);
            
            return view('kelas.edit', compact('kelas'));
        } catch (RequestException $e) {
            return back()->with('error', 'Error fetching data: ' . $e->getMessage());
        }
    }
```
### maka solusinya itu =

```php
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
```

### 4. Kalau primary key merupakan auto increment

#### A. store() diubah menjadi ini

```php
public function store(Request $request)
{
    $request->validate([
        'nama_prodi' => 'required',
    ]);

    try {
        $response = $this->client->request('POST', $this->baseUrl, [
            'json' => [
                'nama_prodi' => $request->nama_prodi,
                // Jangan kirim 'id_prodi' karena auto increment
            ]
        ]);

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan');
    } catch (RequestException $e) {
        return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
    }
}
```

#### B. Update
```php
public function update(Request $request, $id_prodi)
{
    $request->validate([
        'nama_prodi' => 'required',
    ]);

    try {
        $response = $this->client->request('PUT', $this->baseUrl . '/' . $id_prodi, [
            'json' => [
                'nama_prodi' => $request->nama_prodi,
                // 'id_prodi' tidak perlu disertakan saat update jika auto increment
            ]
        ]);

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui');
    } catch (RequestException $e) {
        return back()->with('error', 'Error updating data: ' . $e->getMessage())->withInput();
    }
}
```

#### C. create.blade.php

```php

<div>
    <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
    <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nama_prodi') border-red-500 @enderror" required>
    @error('nama_prodi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

```

### 5. Kalau 

```php
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

```
menjadi ini

```php
public function store(Request $request)
{
    $request->validate([
        'kode_kelas' => 'required',
        'nama_kelas' => 'required',
    ]);

    try {
        $response = $this->client->request('POST', $this->baseUrl, [
            'form_params' => [
                'kode_kelas' => $request->kode_kelas,
                'nama_kelas' => $request->nama_kelas,
            ]
        ]);

        return redirect()->route('kelas.index')->with('success', 'kelas berhasil ditambahkan');
    } catch (RequestException $e) {
        return back()->with('error', 'Error adding data: ' . $e->getMessage())->withInput();
    }
}

```

## DATA CONTROLLER KELAS SEBELUMYA

```PHP
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
```

## DATA CONTROLLER PRODI SEBELUMNYA

```php
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

```

```php
$response = Http::asForm()->post($this->baseUrl
```