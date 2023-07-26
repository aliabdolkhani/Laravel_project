<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complexes extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Salons()
    {
        return $this->hasMany(salons::class,'complex_id');
    }
    protected $fillable = ['name', 'phone', 'creator_id', 'email', 'verify'];
}
