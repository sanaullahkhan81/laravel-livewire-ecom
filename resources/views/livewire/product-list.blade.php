<div class="bg-white p-6 rounded-lg shadow-lg w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-4">
    @foreach($products as $product)
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <div>
                <img class="w-full object-cover h-48 rounded-t-lg" src="https://images.unsplash.com/photo-1646753522408-077ef9839300?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8NjZ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" alt="Product Image">
            </div>
            <h2 class="mt-4 text-xl font-semibold text-gray-900">
                <a href="#">{{ $product->name }}</a>
            </h2>
            <p class="mt-2 text-gray-500 text-sm leading-relaxed">
                {{ $product->description }}
            </p>
            <div class="mt-4 flex justify-between items-center">
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">£{{ $product->price }}</span>
                <button  wire:click.prevent="addItem({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full inline-flex items-center">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </div>
        </div>
    @endforeach
    <!-- Display Pagination Links -->
    {{ $products->links() }}
</div>
