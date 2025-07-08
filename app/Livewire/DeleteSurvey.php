<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Survey;
use Livewire\Component;

class DeleteSurvey extends Component
{
    public $surveyId;
    public $password;
    public function mount($surveyId)
    {
        $this->surveyId = $surveyId;
    }

    public function render()
    {
        return view('livewire.delete-survey');
    }

    public function deleteSurvey()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveyStructure.delete',$this->surveyId);
        }

        $survey = Survey::find($this->surveyId);
        $survey->delete();

        session()->flash('success', 'Survey deleted successfully.');

        return redirect()->route('surveys.index');
    }
}
