<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartCount extends Component
{
    public $count = 0;

    // Load count from session when component is mounted
    public function mount()
    {
        $this->count = session('cartCount', 0); // Get the cart count from the session or default to 0
    }

    protected $listeners = ['cartCountUpdated' => 'updateCount'];

    public function updateCount($count)
    {
        $this->count = $count;
        // Save the cart count to the session
        session(['cartCount' => $count]);
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
