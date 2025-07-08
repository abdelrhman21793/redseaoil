<?php

namespace App\Livewire;

use App\Models\SurveyWell;
use Livewire\Component;

class DeleteSurveyWell extends Component
{
    public $surveyWellId;
    public $password;
    public function mount($surveyWellId)
    {
        $this->surveyWellId = $surveyWellId;
    }
    public function render()
    {
        return view('livewire.delete-survey-well');
    }
    public function deleteSurveyWell()
    {
        if (!password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveywells.delete',$this->surveyWellId);
        }

        $surveyWell = SurveyWell::find($this->surveyWellId);
        $surveyWell->delete();

        session()->flash('success', 'survey Well deleted successfully.');

        return redirect()->route('surveywells.index');
    }
}
