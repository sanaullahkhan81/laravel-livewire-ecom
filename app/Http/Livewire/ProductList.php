<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination; // Use the pagination trait

    public array $cart = [];

    protected $listeners = ['addItemToCart' => 'addItem'];

    /**
     * @param $itemId
     * @param $itemName
     * @param $price
     * @return void
     */
    public function addItem($itemId, $itemName, $price): void
    {
        // Emit event
        $this->emit('itemAdded', $itemId, $itemName, $price);
    }

    /**
     * @param int $itemId
     * @return void
     */
    public function removeItem(int $itemId): void
    {
        // ... remove item logic
        $this->emit('cartCountUpdated', count($this->cart));
    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        // Use paginate instead of all for the products.
        $products = Product::paginate(10);
        return view('livewire.product-list', ['products' => $products]);
    }


}
