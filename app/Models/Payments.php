<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Salons()
    {
        return $this->belongsTo(Salons::class);
    }
    protected $fillable = ['user_id', 'payment_date', 'status', 'amount', 'payment_id', 'salon_id'];
}
