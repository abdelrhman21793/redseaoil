<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Survey;
use Livewire\Component;

class EditSurvey extends Component
{
    public $surveyId;
    public $newSurveyName;

    public function mount($surveyId)
    {
        $this->surveyId = $surveyId;
        $survey=Survey::find($surveyId);
        $this->newSurveyName = $survey->name;
    }
    public function render()
    {
        return view('livewire.edit-survey');
    }
    public function updateSurvey()
    {
        $existingSurvey=Survey::where('name',$this->newSurveyName)
                                ->where('id','!=',$this->surveyId)
                                ->first();
        if($existingSurvey)
        {
            session()->flash('fail', 'The Survey Name Is Already In Use.');
            return redirect()->route('structures.index');
        }elseif($this->newSurveyName==''){
            session()->flash('fail', 'The Survey Name Can\'t Be Empty');
            return redirect()->route('surveys.index');
        }
        $survey = Survey::find($this->surveyId);
        $survey->name = $this->newSurveyName;
        $survey->save();

        session()->flash('success', 'Survey updated successfully.');

        return redirect()->route('surveys.index');
    }
}
