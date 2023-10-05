<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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

        // store each item from session cart to database
        foreach (session('cart', []) as $item) {
            $user->cartItems()->updateOrCreate(
                [
                    'product_id' => $item['id'],  // Use the item's product_id to determine existence
                ],
                [
                    'item_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]
            );
        }

        // Clear the session cart
        session()->forget('cart');
    }
}
