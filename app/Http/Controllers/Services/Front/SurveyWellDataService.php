<?php

namespace App\Http\Controllers\Services\Front;
use App\Http\Controllers\Interfaces\Front\SurveyWellDataServiceInterface;
use App\Models\SurveyStructure;
use App\Models\SurveyStructure_description;
use App\Models\SurveyWell;
use App\Models\SurveyWell_data;


use Illuminate\Support\Facades\Validator;

class SurveyWellDataService implements SurveyWellDataServiceInterface
{
    public $well,$well_data,$structure_description,$structure;
    public function __construct(SurveyWell $well,SurveyWell_data $well_data,SurveyStructure_description $structure_description,SurveyStructure $structure)
    {
        $this->well = $well;
        $this->well_data = $well_data;
        $this->structure_description = $structure_description;
        $this->structure = $structure;
    }

    public function publishNewWell($request,$published)
    {
        $well=$this->well->createWell($request,$published);
        $wellDataInputs= $request->input('survey_well_data');
        foreach($wellDataInputs as $wellDataInput){
            if(isset($wellDataInput['survey_structure_description_id'])){
                $structure_desc=$this->structure_description->findOrfail($wellDataInput['survey_structure_description_id']);
                //(string&Int&Boolean) or List or Multitext
                $type=$structure_desc->type;
                if(($type == 'String') || ($type == 'Int') || ($type == 'Boolean') || ($type == 'List')|| ($type=='User') || ($type=='Date')){
                    $this->well_data->createStringIntBoolList($well,$structure_desc->id,$wellDataInput['data']);
                }elseif($type=='MultiText'){
                    $data = json_decode($wellDataInput['data'], true);
                    $pi = isset($data['Pi']) ? $data['Pi'] : null;
                    $pd = isset($data['Pd']) ? $data['Pd'] : null;
                    $ti = isset($data['Ti']) ? $data['Ti'] : null;
                    $tm = isset($data['Tm']) ? $data['Tm'] : null;
                    $ct = isset($data['Ct']) ? $data['Ct'] : null;
                    $this->well_data->createStringIntBoolList($well,$wellDataInput['survey_structure_description_id'],$data);
                }
            }elseif(!isset($wellDataInput['survey_structure_description_id']) && isset($wellDataInput['structure_id']) && isset($wellDataInput['input']))
            {
                //date && multitext
                $this->structure->findOrfail($wellDataInput['survey_structure_id']);
                $validator = Validator::make(['input' => $wellDataInput['input']], ['input' => 'date']);
                if($validator->fails())
                {
                    $this->well_data->createMultiTextWithInput($wellDataInput,$well);
                }else{
                    $this->well_data->createDateInputWithData($wellDataInput,$well);
                }
            }
        }
    }

    //4-publish from dataWell already exist(edit)

    public function publishOldWell($request,$published)
    {
        $well=$this->well->findOrfail($request->survey_well_id);
        $well_data=$this->well_data->with('survey_structure_description')->where('survey_well_id',$request->survey_well_id)->get();
        $this->well->updateWell($well,$request,$published);
        $wellDataInputs= $request->input('survey_well_data');

        if(!empty($wellDataInputs)){
            foreach($wellDataInputs as $wellDataInput){
                //for edit old data
                if(isset($wellDataInput['survey_well_data_id'])){
                    $well_data_id=$wellDataInput['survey_well_data_id'];
                    $well_data=$this->well_data->with('survey_structure_description')->where('id',$well_data_id)->first();
                    $type=$well_data->survey_structure_description->type;
                    if(!isset($wellDataInput['input'])){
                        if(($type == 'String') || ($type == 'Int') || ($type == 'Boolean') || ($type=='List')|| ($type=='User') || ($type=='Date')){
                            $well_data->update([
                                'data'=>json_encode($wellDataInput['data'])
                            ]);
                        }elseif($type=='MultiText'){
                            $data = json_decode($wellDataInput['data'], true);
                            $pi = isset($data['Pi']) ? $data['Pi'] : null;
                            $pd = isset($data['Pd']) ? $data['Pd'] : null;
                            $ti = isset($data['Ti']) ? $data['Ti'] : null;
                            $tm = isset($data['Tm']) ? $data['Tm'] : null;
                            $ct = isset($data['Ct']) ? $data['Ct'] : null;
                            $well_data->update([
                                'data'=>json_encode($data, JSON_UNESCAPED_UNICODE)
                            ]);
                        }
                    }else{
                        if($type=='MultiText'){
                            $data = json_decode($wellDataInput['data'], true);
                            $pi = isset($data['Pi']) ? $data['Pi'] : null;
                            $pd = isset($data['Pd']) ? $data['Pd'] : null;
                            $ti = isset($data['Ti']) ? $data['Ti'] : null;
                            $tm = isset($data['Tm']) ? $data['Tm'] : null;
                            $ct = isset($data['Ct']) ? $data['Ct'] : null;
                            $well_data->survey_structure_description->update([
                                'input'=>$wellDataInput['input']
                            ]);
                            $well_data->update([
                                'data'=>json_encode($data, JSON_UNESCAPED_UNICODE)
                            ]);
                        }elseif($type=='date_desc'){
                            $well_data->survey_structure_description->update([
                                'input'=>$wellDataInput['input']
                            ]);
                            $well_data->update([
                                'data'=>json_encode($wellDataInput['data'])
                            ]);
                        }
                    }
                }
                //for store new data
                elseif(!isset($wellDataInput['survey_well_data_id'])){
                    if(isset($wellDataInput['survey_structure_description_id'])){
                        $structure_desc=$this->structure_description->findOrfail($wellDataInput['survey_structure_description_id']);
                        //(string&Int&Boolean) or List or Multitext
                        $type=$structure_desc->type;
                        if(($type == 'String') || ($type == 'Int') || ($type == 'Boolean') || ($type == 'List')|| ($type=='User') || ($type=='Date')){
                            $this->well_data->createStringIntBoolList($well,$structure_desc->id,$wellDataInput['data']);
                        }elseif($type=='MultiText'){
                            $data = json_decode($wellDataInput['data'], true);
                            $pi = isset($data['Pi']) ? $data['Pi'] : null;
                            $pd = isset($data['Pd']) ? $data['Pd'] : null;
                            $ti = isset($data['Ti']) ? $data['Ti'] : null;
                            $tm = isset($data['Tm']) ? $data['Tm'] : null;
                            $ct = isset($data['Ct']) ? $data['Ct'] : null;
                            $this->well_data->createStringIntBoolList($well,$wellDataInput['survey_structure_description_id'],$data);
                        }
                    }elseif(!isset($wellDataInput['survey_structure_description_id']) && isset($wellDataInput['survey_structure_id']) && isset($wellDataInput['input']))
                    {
                        //date && multitext
                        $this->structure->findOrfail($wellDataInput['survey_structure_id']);
                        $validator = Validator::make(['input' => $wellDataInput['input']], ['input' => 'date']);
                        if($validator->fails())
                        {
                            $this->well_data->createMultiTextWithInput($wellDataInput,$well);
                        }else{
                            $this->well_data->createDateInputWithData($wellDataInput,$well);
                        }
                    }
                }
            }
        }
    }


    public function requestToEdit($request,$published,$wellRequest)
    {
        $well=$this->well->where('id',$wellRequest->well_id)->first();
        $well_data=$this->well_data->with('survey_structure_description')->where('survey_well_id',$wellRequest->survey_well_id)->get();
        $this->well->updateWell($well,$request,$published);
        $wellDataInputs= $request->input('survey_well_data');

        if(!empty($wellDataInputs)){
            foreach($wellDataInputs as $wellDataInput){
                //for edit old data
                if(isset($wellDataInput['survey_well_data_id'])){
                    $well_data_id=$wellDataInput['survey_well_data_id'];
                    $well_data=$this->well_data->with('survey_structure_description')->where('id',$well_data_id)->first();
                    $type=$well_data->survey_structure_description->type;
                    if(!isset($wellDataInput['input'])){
                        if(($type == 'String') || ($type == 'Int') || ($type == 'Boolean') || ($type=='List')|| ($type=='User') || ($type=='Date')){
                            $well_data->update([
                                'data'=>json_encode($wellDataInput['data'])
                            ]);
                        }elseif($type=='MultiText'){
                                $data = json_decode($wellDataInput['data'], true);
                                $pi = isset($data['Pi']) ? $data['Pi'] : null;
                                $pd = isset($data['Pd']) ? $data['Pd'] : null;
                                $ti = isset($data['Ti']) ? $data['Ti'] : null;
                                $tm = isset($data['Tm']) ? $data['Tm'] : null;
                                $ct = isset($data['Ct']) ? $data['Ct'] : null;
                                $well_data->update([
                                    'data'=>json_encode($data, JSON_UNESCAPED_UNICODE)
                                ]);
                        }
                    }else{
                        if($type=='MultiText'){
                            $data = json_decode($wellDataInput['data'], true);
                            $pi = isset($data['Pi']) ? $data['Pi'] : null;
                            $pd = isset($data['Pd']) ? $data['Pd'] : null;
                            $ti = isset($data['Ti']) ? $data['Ti'] : null;
                            $tm = isset($data['Tm']) ? $data['Tm'] : null;
                            $ct = isset($data['Ct']) ? $data['Ct'] : null;
                            $well_data->survey_structure_description->update([
                                'input'=>$wellDataInput['input']
                            ]);
                            $well_data->update([
                                'data'=>json_encode($data, JSON_UNESCAPED_UNICODE)
                            ]);
                        }elseif($type=='date_desc'){
                            $well_data->survey_structure_description->update([
                                'input'=>$wellDataInput['input']
                            ]);
                            $well_data->update([
                                'data'=>json_encode($wellDataInput['data'])
                            ]);
                        }
                    }
                }
            }
        }
    }
}
