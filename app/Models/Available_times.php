<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Available_times extends Model
{
    use HasFactory;
    public function salons()
    {
        return $this->belongsTo(Salons::class);
    }
    protected $fillable = ['salon_id', 'start_time', 'end_time', 'price', 'week_day'];
}
