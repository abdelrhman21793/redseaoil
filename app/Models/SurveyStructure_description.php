<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyStructure_description extends Model
{
    use HasFactory;use HasFactory;
    protected $table='survey_structure_descriptions';
    protected $fillable=[
        'survey_structure_id','input','type','is_require','data','user_id','survey_well_id','view'
    ];

    public function survey_structure()
    {
        return $this->belongsTo(SurveyStructure::class);
    }

    public function survey_wells()
    {
        return $this->belongsToMany(SurveyWell::class,'survey_well_data','survey_structure_description_id','survey_well_id','id','id')
            ->withPivot(['data'])
            ->using(SurveyWell_data::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
