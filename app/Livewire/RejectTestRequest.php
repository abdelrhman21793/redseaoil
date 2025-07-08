<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\TestRequest;
use Livewire\Component;

class RejectTestRequest extends Component
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
            return redirect()->route('testrequests.reject',$this->RequestId);
        }

        $request = TestRequest::find($this->RequestId);
        $request->delete();

        session()->flash('success', 'The Request Rejected successfully.');

        return redirect()->route('testrequests.index');
    }
}
