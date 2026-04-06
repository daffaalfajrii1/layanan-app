<?php

namespace App\Models\Registration;

use App\Models\Service\ServiceDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_id',
        'service_document_id',
        'value',
        'file_path',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function document()
    {
        return $this->belongsTo(ServiceDocument::class, 'service_document_id');
    }
}
