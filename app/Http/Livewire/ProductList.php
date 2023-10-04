<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $products;

    public $cart = [];

    protected $listeners = ['addItemToCart' => 'addItem'];

    public function addItem($itemId, $itemName, $price): void
    {
        // Emit event
        $this->emit('itemAdded', $itemId, $itemName, $price);
    }

    public function removeItem($itemId)
    {
        // ... remove item logic
        $this->emit('cartCountUpdated', count($this->cart));
    }

    public function render()
    {
        $this->products = Product::all();
        return view('livewire.product-list');
    }


}
