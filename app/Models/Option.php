<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Option extends Model
{
    use HasFactory;
    protected $table="options_structure";
    protected $fillable=[
        'name'
    ];

    public static function createOptionWithStruct_StructDesc(Request $request)
    {
        $option=Option::create([
            'name'=>$request->optionName
        ]);
        $structure=Structure::create([
            'option_id'=>$option->id,
            'name'=>$request->structureName
        ]);
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    Structure_description::create([
                        'structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
        if(isset($request->structuresDesMenu)){
            foreach($request->structuresDesMenu as $type=>$struc){
                if(!empty($struc['input'])){
                    Structure_description::create([
                        'structure_id'=>$structure->id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'data'=>(isset($struc['data']))?json_encode($struc['data']):null,
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
    }

    public static function createOptionWithStruct(Request $request)
    {
        $option=Option::create([
            'name'=>$request->optionName
        ]);
        Structure::create([
            'option_id'=>$option->id,
            'name'=>$request->structureName
        ]);
    }

    public static function createOption(Request $request)
    {
        Option::create([
            'name'=>$request->optionName
        ]);
    }
    public function structures()
    {
        return $this->hasMany(Structure::class);
    }

}
