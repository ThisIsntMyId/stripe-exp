<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                @foreach ($products as $product)

                <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                    <div class="relative">
                        <img alt="moto" src="{{$product->image}}" class="absolute -right-10 -bottom-8 h-40 w-40 mb-4"/>
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
                    <div class="grid grid-col-2 gap-2">
                        <a href="{{route('products.show', ['product' => $product->id])}}" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                            View
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 my-4">
                {!! $products->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>
