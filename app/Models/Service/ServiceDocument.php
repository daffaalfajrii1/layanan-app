<?php

namespace App\Models\Service;

use App\Models\Registration\RegistrationDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'name',
        'type',
        'is_required',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function registrationDocuments()
    {
        return $this->hasMany(RegistrationDocument::class, 'service_document_id');
    }
}
