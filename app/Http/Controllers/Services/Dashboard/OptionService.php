<?php

namespace App\Http\Controllers\Services\Dashboard;

use App\Http\Controllers\Interfaces\Dashboard\OptionServiceInterface;
use App\Models\Option;
use App\Models\Structure;
use Illuminate\Support\Facades\DB;
use Throwable;

class OptionService implements OptionServiceInterface
{
    public $option;
    public $structure;
    public function __construct(Option $option,Structure $structure)
    {
        $this->option=$option;
        $this->structure=$structure;
    }
    public function indexOption()
    {
        return $this->option->with('structures')->paginate('5');
    }
    public function optionStore($data)
    {
        DB::beginTransaction();
        try{
            if($data->structureName != '' && (is_array($data->structuresDes )
                || is_array($data->structuresDesMenu)) && (!empty($data->structuresDes) || !empty($data->structuresDesMenu))){
                $this->option->createOptionWithStruct_StructDesc($data);
            }elseif($data->structureName != '' && (is_null($data->structuresDes) || empty($data->structuresDes))){
                $this->option->createOptionWithStruct($data);
            }
            DB::commit();
        }catch(Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

}
