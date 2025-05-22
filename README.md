# LANGKAH LANGKAH MENGUBAH

### 1. Ambil data dari repo front end
### 2. Atur ENV

SESSION_DRIVER=file

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=frontend_sinilai
DB_USERNAME=root
DB_PASSWORD=

### 2. Masukan sesuai directory nya
isi floder frontend : controller, view, route

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
