<?php

namespace App\Livewire;

use App\Models\TestWell;
use Livewire\Component;

class DeleteTestWell extends Component
{
    public $testWellId;
    public $password;
    public function mount($testWellId)
    {
        $this->testWellId = $testWellId;
    }
    public function render()
    {
        return view('livewire.delete-test-well');
    }
    public function deleteTestWell()
    {
        if (!password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('testwells.delete',$this->testWellId);
        }

        $testWell = TestWell::find($this->testWellId);
        $testWell->delete();

        session()->flash('success', 'Test Well deleted successfully.');

        return redirect()->route('testwells.index');
    }
}
