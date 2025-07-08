<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id","well_id","description","status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function well()
    {
        return $this->belongsTo(Well::class);
    }
}
