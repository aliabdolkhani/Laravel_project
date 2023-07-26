<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon_reserves extends Model
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
    protected $fillable = ['salon_id', 'day', 'start_time', 'end_time', 'price', 'user_id'];
}
