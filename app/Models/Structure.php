<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Structure extends Model
{
    use HasFactory;
    protected $table="structures";
    protected $fillable=[
        'name','option_id','order'
    ];
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function structure_descriptions()
    {
        return $this->hasMany(Structure_description::class);
    }
    public static function createStruct(Request $request)
    {
        $str=Structure::create([
            'option_id'=>$request->option_id,
            'name'=>$request->structureName
        ]);
        return $str;
    }
    public static function createDesc_Menu(Request $request,$id)
    {
        // dd($request);
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    Structure_description::updateOrcreate([
                        'structure_id'=>$id,
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
                    Structure_description::updateOrcreate([
                        'structure_id'=>$id,
                        'input'=>$struc['input'],
                        'type'=>$struc['type'],
                        'is_require'=>(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional',
                        'view'=>(isset($struc['view']) &&($struc['view'])=='View')?'View':'None',
                        'data'=>json_encode($struc['data']),
                        'user_id'=>Auth::id()
                    ]);
                }
            }
        }
    }
    public static function createStruct_Desc_menu(Request $request)
    {
        $structure=Structure::createStruct($request);
        Structure::createDesc_Menu($request, $structure->id);
    }

    public static function UpdateOptionStruc(Request $request,$id)
    {
        $structure=Structure::findOrfail($id);
        $structure->option_id=$request->option_id;
        $structure->name=$request->structureName;
        return $structure;
    }

    public static function UpdateStrucDesc(Request $request,$id)
    {
        $structure=Structure::UpdateOptionStruc($request,$id);
        if(isset($request->structuresDesUpdate)){
            foreach($request->structuresDesUpdate as $type=>$struc)
            {
                if(isset($struc['id']) && !empty($struc['input'])){
                    $struc_desc=Structure_description::findOrfail($struc['id']);
                    $struc_desc->input=$struc['input'];
                    $struc_desc->type=$struc['type'];
                    $struc_desc->is_require=(isset($struc['is_require']) &&($struc['is_require'])=='Required')?'Required':'Optional';
                    $struc_desc->view=(isset($struc['view']) &&($struc['view'])=='View')?'View':'None';
                    if(isset($struc['data'])){
                        $struc_desc->data = json_encode($struc['data']);
                    }
                    $struc_desc->save();
                }
                $structure->save();
            }
        }
    }
   public static function booted()
    {
        static::creating(function(Structure $structure)
        {
            $structure->order=Structure::listOrderStructure();
        });
    }
    public static function listOrderStructure()
    {
        $order=Structure::max('order');
        if($order)
        {
            return $order+1;
        }
        return '1';
    }

}
