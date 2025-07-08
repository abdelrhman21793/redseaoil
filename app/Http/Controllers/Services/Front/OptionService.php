<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\OptionServiceInterface;
use App\Models\Option;

class OptionService implements OptionServiceInterface
{
    public $option;
    public function __construct(Option $option)
    {
        $this->option = $option;
    }
    public function listOptions()
    {
        return $this->option->all();
    }
}
