<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = ['base', 'quote', 'rate', 'source', 'fetched_at'];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:4',
            'fetched_at' => 'datetime',
        ];
    }
}
