<?php

namespace App\Livewire;

use App\Models\Request;
use Livewire\Component;

class AcceptSurveyRequest extends Component
{
    public $requestEdit;
    public $password;
    public function mount($requestEdit)
    {
        $this->requestEdit = $requestEdit;
    }
    public function render()
    {
        return view('livewire.accept-survey-request');
    }
    public function acceptRequest()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveyrequests.edit',$this->requestEdit->id);
        }

        // $request = SurveyRequest::find($this->requestEdit->id);
        $this->requestEdit->status='Accept';
        $this->requestEdit->save();

        session()->flash('success', 'The Request accepted successfully.');

        return redirect()->route('surveyrequests.index');
    }
}

