<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saved Cards') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-4">
                @foreach ($cards as $card)
                @dump($card)

                <div class="shadow-lg rounded-2xl p-4 bg-white overflow-hidden">
                    <div class="relative">
                        <div class="w-4/6">
                            <p class="text-gray-800 text-lg font-medium mb-2">
                                {{$card->card->brand}}
                            </p>
                            <p class="text-gray-400 text-xs">
                                {{$card->card->last4}}
                            </p>
                            <p class="text-indigo-500 text-xl font-medium">
                                {{$card->card->exp_month}} / {{$card->card->exp_year}}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-col-2 gap-2">
                        <form action="{{route('saved-cards.charge', ['card' => $card->card->id])}}" method="POST">
                            @csrf
                            <button type="submit" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                                Charge Now
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div>
                <a href="{{route('saved-cards.create')}}" class="bg-blue-500 text-white px-4 py-2 my-4 mr-4 rounded" >Add new</a>
            </div>
        </div>
    </div>
</x-app-layout>
