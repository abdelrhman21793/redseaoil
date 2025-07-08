<?php

namespace App\Livewire;

use App\Models\SurveyStructure;
use Livewire\Component;
use App\Models\Structure;


class DeleteSurveyStructure extends Component
{
    public $StructureId;
    public $password;
    public function mount($StructureId)
    {
        $this->StructureId = $StructureId;
    }
    public function render()
    {
        return view('livewire.delete-survey-structure');
    }
    public function deleteStructure()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveyStructure.delete',$this->StructureId);
        }

        $structure = SurveyStructure::find($this->StructureId);
        $structure->delete();

        session()->flash('success', 'Structure deleted successfully.');

        return redirect()->route('surveys.index');
    }
}
