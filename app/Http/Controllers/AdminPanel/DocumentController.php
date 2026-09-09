<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Master\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DocumentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'document_file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp',
                ],
                $this->messages()
            );
        } catch (ValidationException $e) {
            return $this->redirectWithModal($e, ['mode' => 'add']);
        }

        $fileName = $this->storeFile($request->file('document_file'), $validated['name']);

        Document::create([
            'name' => $validated['name'],
            'file' => $fileName,
        ]);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        try {
            $validated = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'document_file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,webp',
                ],
                $this->messages()
            );
        } catch (ValidationException $e) {
            return $this->redirectWithModal($e, [
                'mode' => 'edit',
                'id' => $document->id,
                'file' => $document->file,
            ]);
        }

        $fileName = $document->file;

        if ($request->hasFile('document_file')) {
            $fileName = $this->storeFile($request->file('document_file'), $validated['name']);
        }

        $document->update([
            'name' => $validated['name'],
            'file' => $fileName,
        ]);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Data berhasil diubah');
    }

    protected function redirectWithModal(ValidationException $e, array $modal): RedirectResponse
    {
        return redirect()
            ->route('admin.documents.index')
            ->withErrors($e->errors())
            ->withInput()
            ->with('document_modal', $modal);
    }

    protected function storeFile($uploadedFile, string $name): string
    {
        if (! $uploadedFile || ! $uploadedFile->isValid()) {
            $error = $uploadedFile?->getErrorMessage() ?? 'File tidak valid';
            Log::warning('Document upload gagal', [
                'error' => $error,
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
            ]);

            throw ValidationException::withMessages([
                'document_file' => $this->phpUploadHint($error),
            ]);
        }

        $directory = storage_path('app/public/files/documents');
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $fileName = time()
            . '-' . Str::slug($name)
            . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->storeAs('files/documents', $fileName, 'public');

        return $fileName;
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama dokumen wajib diisi.',
            'document_file.required' => 'File dokumen wajib diunggah.',
            'document_file.file' => 'File dokumen tidak valid.',
            'document_file.max' => 'Ukuran file maksimal 10MB.',
            'document_file.mimes' => 'Format diizinkan: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG, GIF, WEBP.',
            'document_file.uploaded' => $this->phpUploadHint('Upload gagal di server.'),
        ];
    }

    protected function phpUploadHint(string $prefix): string
    {
        return $prefix
            . ' PHP upload_max_filesize=' . ini_get('upload_max_filesize')
            . ', post_max_size=' . ini_get('post_max_size')
            . '. Pastikan storage/app/public writable.';
    }
}
