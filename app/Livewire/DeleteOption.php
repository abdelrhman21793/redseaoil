<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;

class DeleteOption extends Component
{
    public $optionId;
    public $password;
    public function mount($optionId)
    {
        $this->optionId = $optionId;
    }

    public function render()
    {
        return view('livewire.delete-option');
    }

    public function deleteOption()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('optionStructures.delete',$this->optionId);
        }

        $option = Option::find($this->optionId);
        $option->delete();

        session()->flash('success', 'Option deleted successfully.');

        return redirect()->route('optionStructures.index');
    }
}
