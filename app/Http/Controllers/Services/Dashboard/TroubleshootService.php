<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\TroubleshootServiceInterface;
use App\Models\Structure;
use App\Models\Troubleshoot;
use App\Models\TroubleshootStructure;
use Illuminate\Support\Facades\DB;
use Throwable;

class TroubleshootService implements TroubleshootServiceInterface
{
    public $troubleshoot;
    public $structure;
    public function __construct(Troubleshoot $troubleshoot, TroubleshootStructure $structure)
    {
        $this->troubleshoot=$troubleshoot;
        $this->structure=$structure;
    }
    public function indexTroubleshoot()
    {
        return $this->troubleshoot->with('troubleshoot_structures')->paginate('5');
    }
    public function troubleshootStore($data)
    {
        DB::beginTransaction();
        try{
            if($data->structureName != '' && (is_array($data->structuresDes )
                || is_array($data->structuresDesMenu)) && (!empty($data->structuresDes) || !empty($data->structuresDesMenu))){
                $this->troubleshoot->createTroubleshootWithStruct_StructDesc($data);
            }elseif($data->structureName != '' && (is_null($data->structuresDes) || empty($data->structuresDes))){
                $this->troubleshoot->createTroubleshootWithStruct($data);
            }
            DB::commit();
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

}
