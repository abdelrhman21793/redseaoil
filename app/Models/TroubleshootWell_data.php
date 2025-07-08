<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class TroubleshootWell_data extends Pivot
{
    use HasFactory;
    protected $table="troubleshoot_well_data";
    public $incrementing = true;
    protected $fillable=[
        'troubleshoot_well_id','troubleshoot_struct_desc_id','data'
    ];

    public function troubleshoot_structure_description()
    {
        return $this->belongsTo(TroubleshootStructure_description::class,'troubleshoot_struct_desc_id');
    }
    public function troubleshoot_well()
    {
        return $this->belongsTo(TroubleshootWell::class,'troubleshoot_well_id');
    }


    public static function createStringIntBoolList($well,$wellDataInput,$data)
    {
        TroubleshootWell_data::create([
            'troubleshoot_well_id'=>$well->id,
            'troubleshoot_struct_desc_id'=> $wellDataInput,
            'data'=> json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);
    }


    public static function createMultiTextWithInput($wellDataInput,$well)
    {
        $data = json_decode($wellDataInput['data'], true);
        $pi = isset($data['Pi']) ? $data['Pi'] : null;
        $pd = isset($data['Pd']) ? $data['Pd'] : null;
        $ti = isset($data['Ti']) ? $data['Ti'] : null;
        $tm = isset($data['Tm']) ? $data['Tm'] : null;
        $ct = isset($data['Ct']) ? $data['Ct'] : null;
        $struct_desc=TroubleshootStructure_description::create([
            'troubleshoot_struct_id'=>$wellDataInput['structure_id'],
            'input'=>$wellDataInput['input'],
            'type'=>'MultiText',
            'user_id'=> Auth::guard('sanctum')->id(),
            'troubleshoot_well_id'=>$well->id
        ]);
        TroubleshootWell_data::create([
            'troubleshoot_well_id'=>$well->id,
            'troubleshoot_struct_desc_id'=>$struct_desc->id,
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);
    }

    public static function createDateInputWithData($wellDataInput, $well)
    {
        $struct_desc=TroubleshootStructure_description::create([
            'troubleshoot_struct_id'=>$wellDataInput['structure_id'],
            'input'=>$wellDataInput['input'],
            'type'=>'date_desc',
            'user_id'=> Auth::guard('sanctum')->id(),
            'troubleshoot_well_id'=>$well->id
        ]);
        TroubleshootWell_data::create([
            'troubleshoot_well_id'=>$well->id,
            'troubleshoot_struct_desc_id'=>$struct_desc->id,
            'data' => json_encode($wellDataInput['data'])
        ]);
    }

    public static function updateDataStringIntBoolList($request,$well_data){
        $well_data->update([
            'data'=>json_encode($request->data)
        ]);
    }

}
