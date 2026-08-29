<?php

namespace App\Services;

use App\Models\Registration\Registration;
use App\Models\Registration\RegistrationDocument;
use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class RegistrationService
{
    public const KEY_INDEX = 'index';
    public const KEY_NAME = 'name';
    public const KEY_API = 'api';

    public function generateRegistrationNumber(): string
    {
        do {
            $prefix = date('Ymd');
            $random = strtoupper(Str::random(6));
            $registrationNumber = "{$prefix}-{$random}";
        } while (Registration::where('registration_number', $registrationNumber)->exists());

        return $registrationNumber;
    }

    public function apiFieldKey(ServiceDocument $document): string
    {
        return 'field_' . $document->id;
    }

    public function validationRuleForDocument(ServiceDocument $document): string
    {
        $rule = $document->is_required ? 'required' : 'nullable';

        return match ($document->type) {
            'file' => "{$rule}|file|max:10240",
            'email' => "{$rule}|email|max:255",
            'date' => "{$rule}|date",
            'time' => "{$rule}|date_format:H:i",
            default => "{$rule}|string|max:255",
        };
    }

    public function validationRules(Service $service, bool|string $keyType = self::KEY_INDEX): array
    {
        $service->loadMissing('documents');
        $keyType = $this->normalizeKeyType($keyType);
        $rules = [];

        foreach ($service->documents as $index => $document) {
            $key = $this->documentInputKey($document, $index, $keyType);
            $rules['documents.' . $this->validationKey($key)] = $this->validationRuleForDocument($document);
        }

        return $rules;
    }

    public function submit(Service $service, array $documents, bool|string $keyType = self::KEY_INDEX): Registration
    {
        $service->loadMissing('documents');
        $keyType = $this->normalizeKeyType($keyType);

        return DB::transaction(function () use ($service, $documents, $keyType) {
            $registration = Registration::create([
                'service_id' => $service->id,
                'registration_number' => $this->generateRegistrationNumber(),
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            foreach ($service->documents as $index => $document) {
                $key = $this->documentInputKey($document, $index, $keyType);
                $input = $documents[$key] ?? null;

                $value = null;
                $filePath = null;

                if ($document->type === 'file' && $input) {
                    $filePath = $this->storeUploadedFile($input);
                } else {
                    $value = $input;
                }

                RegistrationDocument::create([
                    'registration_id' => $registration->id,
                    'service_document_id' => $document->id,
                    'value' => $value,
                    'file_path' => $filePath,
                ]);
            }

            return $registration;
        });
    }

    private function documentInputKey(ServiceDocument $document, int $index, string $keyType): int|string
    {
        return match ($keyType) {
            self::KEY_API => $this->apiFieldKey($document),
            self::KEY_NAME => $document->name,
            default => $index,
        };
    }

    private function normalizeKeyType(bool|string $keyType): string
    {
        if ($keyType === true) {
            return self::KEY_NAME;
        }

        if ($keyType === false) {
            return self::KEY_INDEX;
        }

        return in_array($keyType, [self::KEY_INDEX, self::KEY_NAME, self::KEY_API], true)
            ? $keyType
            : self::KEY_INDEX;
    }

    private function validationKey(int|string $key): string
    {
        return str_replace('.', '\\.', (string) $key);
    }

    private function storeUploadedFile(UploadedFile|TemporaryUploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($originalName) ?: 'document';
        $fileName = now()->format('YmdHis') . '_' . Str::random(8) . '_' . $safeName;

        if ($extension) {
            $fileName .= '.' . $extension;
        }

        return $file->storeAs('documents', $fileName, 'public');
    }
}
