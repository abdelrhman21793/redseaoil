<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Structure;


class DeleteStructure extends Component
{
    public $StructureId;
    public $password;
    public function mount($StructureId)
    {
        $this->StructureId = $StructureId;
    }
    public function render()
    {
        return view('livewire.delete-structure');
    }
    public function deleteStructure()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('structure.delete',$this->StructureId);
        }

        $structure = Structure::find($this->StructureId);
        $structure->delete();

        session()->flash('success', 'Structure deleted successfully.');

        return redirect()->route('optionStructures.index');
    }
}
