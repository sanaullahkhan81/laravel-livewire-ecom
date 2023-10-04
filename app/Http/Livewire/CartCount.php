<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = ['cartCountUpdated' => 'updateCount'];

    public function updateCount($count)
    {
        $this->count = $count;
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
