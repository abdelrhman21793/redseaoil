<?php

namespace App\Livewire;

use App\Models\Structure_descriotion;
use App\Models\Structure_description;
use Livewire\Component;

class DeleteStructureDesc extends Component
{
    public $structureDescId;
    public $password;
    public function mount($structureDescId)
    {
        $this->structureDescId = $structureDescId;
    }
    public function render()
    {
        return view('livewire.delete-structure-desc');
    }
    public function deleteStructure()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('structures.delete',$this->structureDescId);
        }

        $structureDesc = Structure_description::find($this->structureDescId);
        $structureDesc->delete();

        session()->flash('success', 'Structure Description deleted successfully.');

        return redirect()->route('optionStructures.index');
    }
}
