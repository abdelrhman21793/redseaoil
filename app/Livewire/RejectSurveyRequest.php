<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\SurveyRequest;
use Livewire\Component;

class RejectSurveyRequest extends Component
{
    public $RequestId;
    public $password;
    public function mount($RequestId)
    {
        $this->RequestId = $RequestId;
    }
    public function render()
    {
        return view('livewire.reject-request');
    }
    public function rejectRequest()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('surveyrequests.reject',$this->RequestId);
        }

        $request = SurveyRequest::find($this->RequestId);
        $request->delete();

        session()->flash('success', 'The Request Rejected successfully.');

        return redirect()->route('surveyrequests.index');
    }
}
