<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Troubleshoot;
use Livewire\Component;

class EditTroubleshoot extends Component
{
    public $troubleshootId;
    public $newTroubleshootName;

    public function mount($troubleshootId)
    {
        $this->troubleshootId = $troubleshootId;
        $toubleshoot=Troubleshoot::find($troubleshootId);
        $this->newTroubleshootName = $toubleshoot->name;
    }
    public function render()
    {
        return view('livewire.edit-troubleshoot');
    }
    public function updateTroubleshoot()
    {
        $existingTroubleshoot=Troubleshoot::where('name',$this->newTroubleshootName)
                                ->where('id','!=',$this->troubleshootId)
                                ->first();
        if($existingTroubleshoot)
        {
            session()->flash('fail', 'The Troubleshoot Name Is Already In Use.');
            return redirect()->route('structures.index');
        }elseif($this->newTroubleshootName==''){
            session()->flash('fail', 'The Troubleshoot Name Can\'t Be Empty');
            return redirect()->route('toubleshoots.index');
        }
        $troubleshoot = Troubleshoot::find($this->troubleshootId);
        $troubleshoot->name = $this->newTroubleshootName;
        $troubleshoot->save();

        session()->flash('success', 'Troubleshoot updated successfully.');

        return redirect()->route('troubleshoots.index');
    }
}
