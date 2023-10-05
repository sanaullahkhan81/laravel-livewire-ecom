<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Cart extends Component
{
    public array $cart = [];
    public $totalPrice = 0;
    protected $listeners = ['itemAdded' => 'addItemToCart'];

    public function mount()
    {
        $this->cart = session()->get('cart', []); // Retrieve cart from session or default to empty array
        $this->totalPrice = $this->calculateTotalPrice(); // Calculate total price
    }

    public function updatedCart()
    {
        session()->put('cart', $this->cart); // Store the updated cart in the session
        $this->updateCartCount();
    }

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
        $this->storeCartInSession(); // Store cart in session

    }

    public function removeItem($index)
    {
        unset($this->cart[$index]); // Remove item from cart
        $this->cart = array_values($this->cart); // Reindex array
        $this->emit('cartCountUpdated', array_sum(array_column($this->cart, 'quantity'))); // Update the cart count
        $this->calculateTotalPrice(); // Update the total price
        $this->storeCartInSession(); // Store cart in session
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
        $this->emit('cartCountUpdated', $totalQuantity);
    }

    private function storeCartInSession()
    {
        session(['cart' => $this->cart]); // Store the cart data in the session
    }

}
