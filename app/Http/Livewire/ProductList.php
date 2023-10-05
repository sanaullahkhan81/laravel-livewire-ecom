<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination; // Use the pagination trait

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
        // Use paginate instead of all for the products.
        $products = Product::paginate(10);
        return view('livewire.product-list', ['products' => $products]);
    }


}
