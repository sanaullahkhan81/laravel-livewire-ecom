<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Cart extends Component
{
    public array $cart = [];
    public float $totalPrice = 0;
    protected $listeners = ['itemAdded' => 'addItemToCart'];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mount(): void
    {
        $this->cart = session()->get('cart', []); // Retrieve cart from session or default to empty array
        $this->totalPrice = $this->calculateTotalPrice(); // Calculate total price
    }

    /**
     * @return void
     */
    public function updatedCart(): void
    {
        session()->put('cart', $this->cart); // Store the updated cart in the session
        $this->updateCartCount();
    }

    /**
     * @param int $itemId
     * @param string $itemName
     * @param float $itemPrice
     * @return void
     */
    public function addItemToCart(int $itemId, string $itemName, float $itemPrice): void
    {
        $found = false;
        // Check if item is already in the cart
        foreach ($this->cart as $index => $item) {
            if ($item['id'] === $itemId) {
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

    /**
     * @param $index
     * @return void
     */
    public function removeItem($index): void
    {
        unset($this->cart[$index]); // Remove item from cart
        $this->cart = array_values($this->cart); // Reindex array
        $this->emit('cartCountUpdated', array_sum(array_column($this->cart, 'quantity'))); // Update the cart count
        $this->calculateTotalPrice(); // Update the total price
        $this->storeCartInSession(); // Store cart in session
    }

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        $this->totalPrice = $this->calculateTotalPrice();
        return view('livewire.cart', ['cartItems' => $this->cart]);
    }

    /**
     * @return float|int
     */
    public function calculateTotalPrice(): float|int
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * @return void
     */
    public function updateCartCount(): void
    {
        $totalQuantity = array_sum(array_column($this->cart, 'quantity'));
        $this->emit('cartCountUpdated', $totalQuantity);
    }

    /**
     * @return void
     */
    private function storeCartInSession(): void
    {
        session(['cart' => $this->cart]); // Store the cart data in the session
    }

    /**
     * @param int $itemId
     * @return void
     */
    public function decrementQuantity(int $itemId): void
    {
        foreach ($this->cart as $index => $item) {
            if ($item['id'] === $itemId && $item['quantity'] > 1) {
                $this->cart[$index]['quantity']--;
            }
        }
        $this->updateCartCount();
        $this->storeCartInSession(); // Store cart in session
    }

    /**
     * @param int $itemId
     * @return void
     */
    public function incrementQuantity(int $itemId): void
    {
        foreach ($this->cart as $index => $item) {
            if ($item['id'] === $itemId) {
                $this->cart[$index]['quantity']++;
            }
        }
        $this->updateCartCount();
        $this->storeCartInSession(); // Store cart in session
    }

}
