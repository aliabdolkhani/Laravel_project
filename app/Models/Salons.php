<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salons extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Complexes()
    {
        return $this->belongsTo(Complexes::class);
    }
    public function Payments()
    {
        return $this->hasMany(Payments::class,'salon_id');
    }
    public function Available_times()
    {
        return $this->hasMany(Available_times::class,'salon_id');
    }
    protected $fillable = ['name', 'phone', 'price', 'complex_id', 'creator_id'];
}
