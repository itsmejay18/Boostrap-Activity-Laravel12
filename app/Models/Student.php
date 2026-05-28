<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'year',
        'course',
        'photo_url',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }
}
