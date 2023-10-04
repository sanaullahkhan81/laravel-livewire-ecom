<div class="bg-white p-4 rounded shadow-lg">
    <!-- Cart Header -->
    <div class="cart-header">
        <h2>My Cart</h2>
    </div>
        <!-- Cart Items -->
        <div class="cart-items">
            @forelse($cartItems as $item)
                <p>{{ $item['name'] }} - Quantity: {{ $item['quantity'] }} - Price: £{{ $item['price'] * $item['quantity'] }}</p>
            @empty
                <p>Your cart is empty.</p>
            @endforelse
            <p>Total: £{{ $totalPrice }}</p>
        </div>
</div>
