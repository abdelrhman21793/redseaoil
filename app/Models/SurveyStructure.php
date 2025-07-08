<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyStructure extends Model
{
    use HasFactory;
    protected $table="survey_structures";
    protected $fillable=[
        'name','survey_id','order'
    ];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function survey_structure_descriptions()
    {
        return $this->hasMany(SurveyStructure_description::class);
    }
    public static function createStruct(Request $request)
    {
        $str=SurveyStructure::create([
            'survey_id'=>$request->option_id,
            'name'=>$request->structureName
        ]);
        return $str;
    }
    public static function createDesc_Menu(Request $request,$id)
    {
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    SurveyStructure_description::updateOrcreate([
                        'survey_structure_id'=>$id,
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
                    SurveyStructure_description::updateOrcreate([
                        'survey_structure_id'=>$id,
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
        $structure=SurveyStructure::createStruct($request);
        SurveyStructure::createDesc_Menu($request, $structure->id);
    }

    public static function UpdateOptionStruc(Request $request,$id)
    {
        $structure=SurveyStructure::findOrfail($id);

        $structure->survey_id=$request->option_id;
        $structure->name=$request->structureName;
        return $structure;
    }

    public static function UpdateStrucDesc(Request $request,$id)
    {
        $structure=SurveyStructure::UpdateOptionStruc($request,$id);
        if(isset($request->structuresDesUpdate)){
            foreach($request->structuresDesUpdate as $type=>$struc)
            {
                if(isset($struc['id']) && !empty($struc['input'])){
                    $struc_desc=SurveyStructure_description::findOrfail($struc['id']);
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
        static::creating(function(SurveyStructure $structure)
        {
            $structure->order=SurveyStructure::listOrderStructure();
        });
    }
    public static function listOrderStructure()
    {
        $order=SurveyStructure::max('order');
        if($order)
        {
            return $order+1;
        }
        return '1';
    }

}
