<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TroubleshootRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id","troubleshoot_well_id","description","status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function troubleshoot_well()
    {
        return $this->belongsTo(TroubleshootWell::class);
    }
}
