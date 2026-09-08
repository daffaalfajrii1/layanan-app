# Implementasi Client Layanko API Untuk Web Diskominfo

Dokumen ini adalah brief implementasi untuk agent/developer yang akan menambahkan halaman layanan Layanko di web `diskominfo.rejanglebongkab.go.id`.

## Tujuan

Web Diskominfo menjadi client dari central API Layanko:

- Menampilkan daftar layanan dari Layanko.
- Menampilkan detail layanan beserta schema field.
- Mengirim pendaftaran layanan ke Layanko, termasuk upload file.
- Menyimpan data pendaftaran tetap di database Layanko.
- Tidak menyimpan data pendaftaran duplikat di database web Diskominfo, kecuali nanti dibutuhkan untuk cache/audit lokal.

## Environment

Tambahkan ke `.env` web Diskominfo:

```env
LAYANKO_API_URL=https://layanko.rejanglebongkab.go.id/api
LAYANKO_API_TOKEN=ISI_TOKEN_SANCTUM_CLIENT_DISKOMINFO
```

Jangan commit `.env` dan jangan taruh token di JavaScript/frontend.

Tambahkan ke `config/services.php` web Diskominfo:

```php
'layanko' => [
    'url' => env('LAYANKO_API_URL', 'https://layanko.rejanglebongkab.go.id/api'),
    'token' => env('LAYANKO_API_TOKEN'),
],
```

## API Contract

Semua request selain login memakai header:

```http
Authorization: Bearer {LAYANKO_API_TOKEN}
Accept: application/json
```

Endpoint yang digunakan:

```text
GET  /api/services
GET  /api/services/{slug}
POST /api/services/{slug}/registrations
GET  /api/registrations/{registration_number}
```

Token client Diskominfo minimal memiliki ability:

```text
services:read
registrations:create
registrations:read
```

## Bentuk Data Service

Response `GET /api/services/{slug}` berisi data layanan dan schema field:

```json
{
  "data": {
    "id": 1,
    "name": "Pendaftaran Email Dinas",
    "slug": "pendaftaran-email-dinas",
    "schema": {
      "fields": [
        {
          "id": 12,
          "key": "field_12",
          "label": "Nama Pegawai",
          "type": "text",
          "required": true,
          "input_name": "documents[field_12]",
          "rules": ["required", "string", "max:255"]
        }
      ]
    }
  }
}
```

Gunakan `schema.fields.*.key` sebagai nama input saat submit.

## Format Submit

Submit menggunakan `multipart/form-data`.

Field text:

```text
documents[field_12]=Nama Pemohon
```

Field file:

```text
documents[field_13]=surat.pdf
```

Contoh response sukses:

```json
{
  "data": {
    "registration_number": "20260829-ABC123",
    "status": "pending"
  }
}
```

## Struktur Implementasi Laravel Client

Rekomendasi file di web Diskominfo:

```text
app/Services/LayankoApiService.php
app/Http/Controllers/LayankoServiceController.php
routes/web.php
resources/views/layanko/services/index.blade.php
resources/views/layanko/services/show.blade.php
resources/views/layanko/services/success.blade.php
```

## Service HTTP Client

Buat `app/Services/LayankoApiService.php`:

```php
<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class LayankoApiService
{
    private function client(): PendingRequest
    {
        return Http::withToken(config('services.layanko.token'))
            ->acceptJson()
            ->baseUrl(rtrim(config('services.layanko.url'), '/'));
    }

    public function services(): array
    {
        return $this->client()
            ->get('/services')
            ->throw()
            ->json('data', []);
    }

    public function service(string $slug): array
    {
        return $this->client()
            ->get('/services/' . $slug)
            ->throw()
            ->json('data');
    }

    public function submitRegistration(string $slug, array $documents): array
    {
        $request = $this->client();
        $payload = [];

        foreach ($documents as $key => $value) {
            if ($value instanceof UploadedFile) {
                $request = $request->attach(
                    "documents[$key]",
                    fopen($value->getRealPath(), 'r'),
                    $value->getClientOriginalName()
                );

                continue;
            }

            $payload["documents[$key]"] = $value;
        }

        return $request
            ->post("/services/{$slug}/registrations", $payload)
            ->throw()
            ->json('data');
    }

    public function registration(string $registrationNumber): array
    {
        return $this->client()
            ->get('/registrations/' . $registrationNumber)
            ->throw()
            ->json('data');
    }
}
```

## Controller

Buat `app/Http/Controllers/LayankoServiceController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Services\LayankoApiService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LayankoServiceController extends Controller
{
    public function index(LayankoApiService $layanko)
    {
        return view('layanko.services.index', [
            'services' => $layanko->services(),
        ]);
    }

    public function show(string $slug, LayankoApiService $layanko)
    {
        return view('layanko.services.show', [
            'service' => $layanko->service($slug),
        ]);
    }

    public function store(Request $request, string $slug, LayankoApiService $layanko)
    {
        $service = $layanko->service($slug);
        $rules = $this->rulesFromSchema($service['schema']['fields'] ?? []);

        $validated = $request->validate($rules);

        try {
            $registration = $layanko->submitRegistration($slug, $validated['documents'] ?? []);
        } catch (RequestException $exception) {
            if ($exception->response->status() === 422) {
                throw ValidationException::withMessages(
                    $this->normalizeApiValidationErrors($exception->response->json('errors', []))
                );
            }

            throw $exception;
        }

        return redirect()
            ->route('layanko.services.success', $registration['registration_number'])
            ->with('registration', $registration);
    }

    public function success(string $registrationNumber, LayankoApiService $layanko)
    {
        return view('layanko.services.success', [
            'registration' => $layanko->registration($registrationNumber),
        ]);
    }

    private function rulesFromSchema(array $fields): array
    {
        $rules = ['documents' => ['required', 'array']];

        foreach ($fields as $field) {
            $fieldRules = $field['rules'] ?? [];
            $rules['documents.' . $field['key']] = $this->clientRules($fieldRules);
        }

        return $rules;
    }

    private function clientRules(array $rules): array
    {
        return array_values(array_filter($rules, function (string $rule) {
            return ! str_starts_with($rule, 'exists:')
                && ! str_starts_with($rule, 'unique:');
        }));
    }

    private function normalizeApiValidationErrors(array $errors): array
    {
        $normalized = [];

        foreach ($errors as $key => $messages) {
            $normalized[str_replace('documents.', 'documents.', $key)] = $messages;
        }

        return $normalized;
    }
}
```

## Routes

Tambahkan di `routes/web.php` web Diskominfo:

```php
use App\Http\Controllers\LayankoServiceController;

Route::prefix('layanko')->name('layanko.')->group(function () {
    Route::get('/layanan', [LayankoServiceController::class, 'index'])->name('services.index');
    Route::get('/layanan/{slug}', [LayankoServiceController::class, 'show'])->name('services.show');
    Route::post('/layanan/{slug}', [LayankoServiceController::class, 'store'])->name('services.store');
    Route::get('/registrasi/{registrationNumber}/success', [LayankoServiceController::class, 'success'])->name('services.success');
});
```

## View Index

Buat `resources/views/layanko/services/index.blade.php`:

```blade
@extends('layouts.app')

@section('content')
    <h1>Layanan</h1>

    <div class="row">
        @foreach ($services as $service)
            <div class="col-md-4 mb-3">
                <a href="{{ route('layanko.services.show', $service['slug']) }}" class="card card-body text-decoration-none">
                    <strong>{{ $service['name'] }}</strong>
                </a>
            </div>
        @endforeach
    </div>
@endsection
```

Sesuaikan `layouts.app` dan class CSS dengan template web Diskominfo.

## View Form

Buat `resources/views/layanko/services/show.blade.php`:

```blade
@extends('layouts.app')

@section('content')
    <h1>{{ $service['name'] }}</h1>

    <form method="POST" action="{{ route('layanko.services.store', $service['slug']) }}" enctype="multipart/form-data">
        @csrf

        @foreach ($service['schema']['fields'] as $field)
            <div class="mb-3">
                <label for="{{ $field['key'] }}" class="form-label">
                    {{ $field['label'] }}
                    @if ($field['required'])
                        <span class="text-danger">*</span>
                    @endif
                </label>

                @if ($field['type'] === 'file')
                    <input
                        id="{{ $field['key'] }}"
                        name="documents[{{ $field['key'] }}]"
                        type="file"
                        class="form-control @error('documents.' . $field['key']) is-invalid @enderror"
                        @required($field['required'])
                    >
                @else
                    <input
                        id="{{ $field['key'] }}"
                        name="documents[{{ $field['key'] }}]"
                        type="{{ in_array($field['type'], ['email', 'date', 'time'], true) ? $field['type'] : 'text' }}"
                        value="{{ old('documents.' . $field['key']) }}"
                        class="form-control @error('documents.' . $field['key']) is-invalid @enderror"
                        @required($field['required'])
                    >
                @endif

                @error('documents.' . $field['key'])
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
@endsection
```

## View Success

Buat `resources/views/layanko/services/success.blade.php`:

```blade
@extends('layouts.app')

@section('content')
    <h1>Pendaftaran Berhasil</h1>

    <p>Nomor registrasi:</p>
    <h2>{{ $registration['registration_number'] }}</h2>

    <p>Status: {{ $registration['status'] }}</p>

    <a href="{{ route('layanko.services.index') }}" class="btn btn-primary">Kembali ke Layanan</a>
@endsection
```

## Error Handling

Minimal yang harus ditangani:

- Token salah/kedaluwarsa: API akan membalas `401`.
- Token tidak punya ability: API akan membalas `403`.
- Field tidak valid: API akan membalas `422`.
- Service slug tidak ditemukan: API akan membalas `404`.

Untuk production, jangan tampilkan exception mentah ke user. Tampilkan pesan umum seperti "Layanan sedang tidak tersedia" dan log detail error di server web Diskominfo.

## Checklist Implementasi

- `.env` web Diskominfo berisi `LAYANKO_API_URL` dan `LAYANKO_API_TOKEN`.
- `config/services.php` punya config `layanko`.
- Service HTTP client dibuat.
- Controller dibuat.
- Route dibuat.
- Halaman daftar layanan tampil dari API Layanko.
- Halaman detail membaca schema dari API Layanko.
- Submit text dan upload file berhasil.
- Nomor registrasi dari Layanko tampil di halaman success.
- Token tidak muncul di HTML, JavaScript, log publik, atau repository.

## Verifikasi Manual

Tes koneksi dari web Diskominfo:

```bash
php artisan tinker
```

```php
Http::withToken(config('services.layanko.token'))
    ->baseUrl(config('services.layanko.url'))
    ->get('/services')
    ->json();
```

Tes endpoint langsung:

```bash
curl -H "Authorization: Bearer TOKEN_DISKOMINFO" \
     -H "Accept: application/json" \
     https://layanko.rejanglebongkab.go.id/api/services
```

Jangan commit token asli pada dokumentasi atau source code.
