<?php

namespace App\Http\Controllers\Services\Front;

use App\Http\Controllers\Interfaces\Front\OptionServiceInterface;
use App\Http\Controllers\Interfaces\Front\TestServiceInterface;
use App\Models\Option;
use App\Models\Test;

class TestService implements TestServiceInterface
{
    public $test;
    public function __construct(Test $test)
    {
        $this->test = $test;
    }
    public function listTests()
    {
        return $this->test->all();
    }
}
