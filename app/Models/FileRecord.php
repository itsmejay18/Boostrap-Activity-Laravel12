<?php

namespace App\Models;

use Database\Factories\FileRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRecord extends Model
{
    /** @use HasFactory<FileRecordFactory> */
    use HasFactory;

    public const STATUSES = [
        'Pending',
        'Active',
        'Archived',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'reference_code',
        'category',
        'owner_name',
        'status',
        'description',
    ];
}
