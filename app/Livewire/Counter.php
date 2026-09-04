<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Counter extends Component
{
    #[Layout('layouts.app')]
    #[Title('Counter')]
    public $counter = 0;

    public function increment()
    {
        $this->counter++;
    }

    public function decrement()
    {
        if ($this->counter > 0) {
            $this->counter--;
        }

    }

    public function render()
    {
        return view('livewire.counter');
    }
}
