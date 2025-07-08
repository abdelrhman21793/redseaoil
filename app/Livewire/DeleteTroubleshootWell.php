<?php

namespace App\Livewire;

use App\Models\TroubleshootWell;
use Livewire\Component;

class DeleteTroubleshootWell extends Component
{
    public $troubleshootWellId;
    public $password;
    public function mount($troubleshootWellId)
    {
        $this->troubleshootWellId = $troubleshootWellId;
    }
    public function render()
    {
        return view('livewire.delete-troubleshoot-well');
    }
    public function deleteTroubleshootWell()
    {
        if (!password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('troubleshootwells.delete',$this->troubleshootWellId);
        }

        $troubleshootWell = TroubleshootWell::find($this->troubleshootWellId);
        $troubleshootWell->delete();

        session()->flash('success', 'Troubleshoot Well deleted successfully.');

        return redirect()->route('troubleshootwells.index');
    }
}
