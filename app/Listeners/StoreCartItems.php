<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class StoreCartItems
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;

        $sessionCart = session('cart', []);

        // Delete all existing cart items of this user
        $user->cartItems()->delete();

        // If the cart is not empty, add current cart items to the database
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $item) {
                $user->cartItems()->create([
                    'product_id' => $item['id'],
                    'item_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        // Clear the session cart
        session()->forget('cart');
    }
}
