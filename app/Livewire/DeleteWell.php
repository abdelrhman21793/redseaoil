<?php

namespace App\Livewire;

use App\Models\Well;
use Livewire\Component;

class DeleteWell extends Component
{
    public $WellId;
    public $password;
    public function mount($WellId)
    {
        $this->WellId = $WellId;
    }
    public function render()
    {
        return view('livewire.delete-well');
    }

    public function deleteWell()
    {
        if (!password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('wells.delete',$this->WellId);
        }

        $well = Well::find($this->WellId);
        $well->delete();

        session()->flash('success', 'Well deleted successfully.');

        return redirect()->route('wells.index');
    }
}
