<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total',
        'name',
        'email',
        'address',
        'phone',
        'total_price',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(payment::class);
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }

}
