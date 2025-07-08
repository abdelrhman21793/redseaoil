<?php

namespace App\Livewire;

use App\Models\TroubleshootStructure;
use Livewire\Component;
use App\Models\Structure;


class DeleteTroubleshootStructure extends Component
{
    public $StructureId;
    public $password;
    public function mount($StructureId)
    {
        $this->StructureId = $StructureId;
    }
    public function render()
    {
        return view('livewire.delete-troubleshoot-structure');
    }
    public function deleteStructure()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('troubleshootStructure.delete',$this->StructureId);
        }

        $structure = TroubleshootStructure::find($this->StructureId);
        $structure->delete();

        session()->flash('success', 'Structure deleted successfully.');

        return redirect()->route('troubleshoots.index');
    }
}
