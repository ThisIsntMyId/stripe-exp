<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product : ') }} {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <div class="relative">
                    <img alt="moto" src="{{$product->image}}" class="absolute -right-10 -bottom-8 h-40 w-40 mb-4" />
                    <div class="w-4/6">
                        <p class="text-gray-800 text-lg font-medium mb-2">
                            {{$product->name}}
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{$product->desc}}
                        </p>
                        <p class="text-indigo-500 text-xl font-medium">
                            ${{$product->price}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                <div class="h3">Checkout Error</div>
            </div>
        </div>
    </div>
</x-app-layout>
