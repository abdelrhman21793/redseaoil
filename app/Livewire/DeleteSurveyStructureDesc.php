<?php

namespace App\Livewire;

use App\Models\Structure_descriotion;
use App\Models\Structure_description;
use App\Models\SurveyStructure_description;
use Livewire\Component;

class DeleteSurveyStructureDesc extends Component
{
    public $structureDescId;
    public $password;
    public function mount($structureDescId)
    {
        $this->structureDescId = $structureDescId;
    }
    public function render()
    {
        return view('livewire.delete-survey-structure-desc');
    }
    public function deleteStructure()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveyStructure.delete',$this->structureDescId);
        }

        $structureDesc = SurveyStructure_description::find($this->structureDescId);
        $structureDesc->delete();

        session()->flash('success', 'Structure Description deleted successfully.');

        return redirect()->route('surveys.index');
    }
}
