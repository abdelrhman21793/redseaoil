<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id","survey_well_id","description","status"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function survey_well()
    {
        return $this->belongsTo(SurveyWell::class);
    }
}
