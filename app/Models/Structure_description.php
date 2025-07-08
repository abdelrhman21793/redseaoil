<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure_description extends Model
{
    use HasFactory;use HasFactory;
    protected $table='structure_descriptions';
    protected $fillable=[
        'structure_id','input','type','is_require','data','user_id','well_id','view'
    ];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class,'well_data','structure_description_id','well_id','id','id')
            ->withPivot(['data'])
            ->using(Well_data::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
