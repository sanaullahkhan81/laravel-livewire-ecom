<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CartCount extends Component
{
    public int $count = 0;

    // Load count from session when component is mounted
    public function mount(): void
    {
        $this->count = session('cartCount', 0); // Get the cart count from the session or default to 0
    }

    protected $listeners = ['cartCountUpdated' => 'updateCount'];

    public function updateCount($count): void
    {
        $this->count = $count;
        // Save the cart count to the session
        session(['cartCount' => $count]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.cart-count');
    }
}
