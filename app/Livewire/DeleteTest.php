<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Test;
use Livewire\Component;

class DeleteTest extends Component
{
    public $testId;
    public $password;
    public function mount($testId)
    {
        $this->testId = $testId;
    }

    public function render()
    {
        return view('livewire.delete-test');
    }

    public function deleteTest()
    {
        if (! password_verify($this->password, auth()->user()->password)) {
            session()->flash('fail', 'Incorrect password. Please try again.');
            return redirect()->route('testStructure.delete',$this->testId);
        }

        $test = Test::find($this->testId);
        $test->delete();

        session()->flash('success', 'Test deleted successfully.');

        return redirect()->route('tests.index');
    }
}
