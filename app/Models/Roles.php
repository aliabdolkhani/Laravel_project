<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
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
    protected $fillable = ['complex_id', 'role', 'user_id'];
}
