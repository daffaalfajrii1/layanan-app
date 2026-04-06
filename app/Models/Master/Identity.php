<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    protected $table = 'identity';

    protected $fillable = [
        'name',
        'description',
        'favicon',
        'logo',
        'email',
        'address',
        'google_maps',
        'telephone',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'vision_mission',
        'task_function',
    ];
}
