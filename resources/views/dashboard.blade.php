<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Welcome to ShoppyHub') }}
            </h2>
            <div class="mt-6" x-data="{ open: false }">
                <button class="bg-blue-500 text-white px-4 py-2 rounded no-outline focus:shadow-outline select-none" @click="open = true">
                    <i class="fas fa-shopping-cart"></i> @livewire('cart-count')
                </button>
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center" style="background-color: rgba(0,0,0,.5);" x-show="open">
                    <div class="" @click.away="open = false" style="min-width: 800px">
                        @livewire('shopping-cart')
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
