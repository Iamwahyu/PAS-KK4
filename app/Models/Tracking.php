<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'status',
        'description',
    ];

    public function transaction()
    {
        return $this->belongsTo(transaction::class);
    }
}
