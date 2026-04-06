<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function documents()
    {
        return $this->hasMany(ServiceDocument::class);
    }
}
