<?php

namespace Tests\Feature;

use App\Http\Livewire\Cart;
use App\Http\Livewire\ProductList;
use App\Models\Product;
use Livewire\Livewire;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    public function test_shows_all_products()
    {
        // Arrange: Create some products using a factory
        $products = Product::factory()->count(3)->create();

        // Act & Assert: Check that each product name is visible in the component's output
        Livewire::test(ProductList::class)
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name);
    }

    /**
     * @return void
     */
    public function test_adds_item_to_cart_and_emits_event()
    {
        Livewire::test(Cart::class)
            ->call('addItemToCart', 1, 'Example Item', 100)
            ->assertSee('Example Item') // assert that item name is in the cart
            ->assertEmitted('cartCountUpdated', 1); // assert that cart count update event is emitted with correct quantity
    }

    /**
     * @description Check that when the removeItem method is called, the item gets removed from the cart and the cartCountUpdated and calculateTotalPrice methods are called correctly.
     * @return void
     */
    public function test_removes_item_from_cart_and_updates_count_and_price()
    {
        Livewire::test(Cart::class)
            ->set('cart', [['id' => 1, 'name' => 'Example Item', 'quantity' => 1, 'price' => 100]]) // set initial cart state
            ->call('removeItem', 0)
            ->assertDontSee('Example Item') // assert that item name is NOT in the cart
            ->assertEmitted('cartCountUpdated', 0); // assert that cart count update event is emitted with correct quantity
    }

    /**
     * @description Check that the calculateTotalPrice method correctly sums up the price of items in the cart.
     * @return void
     */
    public function test_calculates_total_price_correctly()
    {
        Livewire::test(Cart::class)
            ->set('cart', [
                ['id' => 1, 'name' => 'Item 1', 'quantity' => 1, 'price' => 100],
                ['id' => 2, 'name' => 'Item 2', 'quantity' => 2, 'price' => 50],
            ]) // set initial cart state
            ->assertSet('totalPrice', 200); // assert that totalPrice is set to the correct amount
    }

    /**
     * @description Check that the updateCartCount method correctly calculates and emits the total item quantity in the cart.
     */
    public function test_updates_cart_count_correctly()
    {
        Livewire::test(Cart::class)
            ->set('cart', [
                ['id' => 1, 'name' => 'Item 1', 'quantity' => 1, 'price' => 100],
                ['id' => 2, 'name' => 'Item 2', 'quantity' => 2, 'price' => 50],
            ]) // set initial cart state
            ->call('updateCartCount')
            ->assertEmitted('cartCountUpdated', 3); // assert that cart count update event is emitted with correct total quantity
    }



}
