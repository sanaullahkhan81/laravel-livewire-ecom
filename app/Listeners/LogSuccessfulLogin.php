<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Fetch user's cart items
        $cartItems = $event->user->cartItems;

        // Convert the cart items into a suitable format for session storage.
                $cartSessionData = $cartItems->map(function($item) {
                    return [
                        'id' => $item->product_id,
                        'name' => $item->item_name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                })->toArray();


        // Store cart items in session
        session(['cart' => $cartSessionData]);

        // Calculate totalQuantity and store it in session
        $totalQuantity = array_sum(array_column($cartSessionData, 'quantity'));
        session(['cartCount' => $totalQuantity]);

    }
}
