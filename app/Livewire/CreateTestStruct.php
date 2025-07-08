<?php

namespace App\Livewire;

use Livewire\Component;

class CreateTestStruct extends Component
{
    public $structuresDes = [];
    public $structuresDesMenu = [];
    public $types;

    public function mount()
    {
        $this->structuresDes = [];
        $this->structuresDesMenu = [];
        $this->types = ['String', 'Int', 'Boolean', 'Date', 'MultiText','List','User'];
    }
    public function render()
    {
        return view('livewire.create-test-struct');
    }
    public function addStruDesc()
    {
        $this->structuresDes[] = ['input', 'type', 'is_require','view'];
    }
    public function addStruMenu()
    {
        $this->structuresDesMenu[] = ['input' => '', 'data' => []];
    }

    public function addData($index)
    {
        $this->structuresDesMenu[$index]['data'][] = '';
    }
    public function removeStruDesc($index)
    {
        unset($this->structuresDes[$index]);
        $this->structuresDes = array_values($this->structuresDes);
    }

    public function removeStruMenu($index)
    {
        unset($this->structuresDesMenu[$index]);
        $this->structuresDesMenu = array_values($this->structuresDesMenu);
    }

    public function removeData($descIndex, $dataIndex)
    {
        unset($this->structuresDesMenu[$descIndex]['data'][$dataIndex]);
        $this->structuresDesMenu[$descIndex]['data'] = array_values($this->structuresDesMenu[$descIndex]['data']);
    }

}
