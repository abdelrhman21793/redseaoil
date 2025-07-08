<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Troubleshoot extends Model
{
    use HasFactory;
    protected $table="troubleshoots";
    protected $fillable=[
        'name'
    ];

    public static function createTroubleshootWithStruct_StructDesc(Request $request)
    {
        $troubleshoot = Troubleshoot::create([
            'name'=>$request->troubleshootName
        ]);
        $structure=TroubleshootStructure::create([
            'troubleshoot_id'=>$troubleshoot->id,
            'name'=>$request->structureName
        ]);
        if(isset($request->structuresDes)){
            foreach($request->structuresDes as $type=>$struc){
                if(!empty($struc['input'])){
                    TroubleshootStructure_description::create([
                        'troubleshoot_struct_id'=>$structure->id,
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
                    TroubleshootStructure_description::create([
                        'troubleshoot_struct_id'=>$structure->id,
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

    public static function createTroubleshootWithStruct(Request $request)
    {
        $troubleshoot=Troubleshoot::create([
            'name'=>$request->troubleshootName
        ]);
        TroubleshootStructure::create([
            'troubleshoot_id'=>$troubleshoot->id,
            'name'=>$request->structureName
        ]);
    }

    public static function createTroubleshoot(Request $request)
    {
        Troubleshoot::create([
            'name'=>$request->troubleshootName
        ]);
    }
    public function troubleshoot_structures()
    {
        return $this->hasMany(TroubleshootStructure::class);
    }

}
