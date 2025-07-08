<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Test;
use Livewire\Component;

class EditTest extends Component
{
    public $testId;
    public $newTestName;

    public function mount($testId)
    {
        $this->testId = $testId;
        $test=Test::find($testId);
        $this->newTestName = $test->name;
    }
    public function render()
    {
        return view('livewire.edit-test');
    }
    public function updateTest()
    {
        $existingTest=Test::where('name',$this->newTestName)
                                ->where('id','!=',$this->testId)
                                ->first();
        if($existingTest)
        {
            session()->flash('fail', 'The Test Name Is Already In Use.');
            return redirect()->route('structures.index');
        }elseif($this->newTestName==''){
            session()->flash('fail', 'The Test Name Can\'t Be Empty');
            return redirect()->route('tests.index');
        }
        $test = Test::find($this->testId);
        $test->name = $this->newTestName;
        $test->save();

        session()->flash('success', 'TestΩ updated successfully.');

        return redirect()->route('tests.index');
    }
}
