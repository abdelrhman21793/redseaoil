<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Troubleshoot;
use Livewire\Component;

class DeleteTroubleshoot extends Component
{
    public $troubleshootId;
    public $password;
    public function mount($troubleshootId)
    {
        $this->troubleshootId = $troubleshootId;
    }

    public function render()
    {
        return view('livewire.delete-troubleshoot');
    }

    public function deleteTroubleshoot()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('troubleshootStructure.delete',$this->troubleshootId);
        }

        $troubleshoot = Troubleshoot::find($this->troubleshootId);
        $troubleshoot->delete();

        session()->flash('success', 'Troubleshoot deleted successfully.');

        return redirect()->route('troubleshoots.index');
    }
}
