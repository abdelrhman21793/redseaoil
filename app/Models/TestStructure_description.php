<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStructure_description extends Model
{
    use HasFactory;use HasFactory;
    protected $table='test_structure_descriptions';
    protected $fillable=[
        'test_structure_id','input','type','is_require','data','user_id','test_well_id','view'
    ];

    public function test_structure()
    {
        return $this->belongsTo(TestStructure::class);
    }

    public function test_wells()
    {
        return $this->belongsToMany(TestWell::class,'test_well_data','test_structure_description_id','test_well_id','id','id')
            ->withPivot(['data'])
            ->using(TestWell_data::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
