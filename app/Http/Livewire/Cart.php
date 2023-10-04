<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Cart extends Component
{
    public array $cart = [];
    public $totalPrice = 0;
    protected $listeners = ['itemAdded' => 'addItemToCart'];

    public function addItemToCart($itemId, $itemName, $itemPrice): void
    {
        $found = false;
        // Check if item is already in the cart
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $itemId) {
                $this->cart[$index]['quantity']++;
                $found = true;
                break;
            }
        }

        // Add item if it wasn't found
        if (!$found) {
            $this->cart[] = [
                'id' => $itemId,
                'name' => $itemName,
                'quantity' => 1,
                'price' => $itemPrice,
            ];
        }
        $this->updateCartCount();

    }

    public function render(): Factory|View|Application
    {
        $this->totalPrice = $this->calculateTotalPrice();
        return view('livewire.cart', ['cartItems' => $this->cart]);
    }

    public function calculateTotalPrice(): float|int
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function updateCartCount()
    {
        $totalQuantity = array_sum(array_column($this->cart, 'quantity'));
        $this->emit('cartUpdated', $totalQuantity);
    }

}
