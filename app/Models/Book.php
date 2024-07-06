<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }
}
