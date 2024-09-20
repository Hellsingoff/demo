<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Меню') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="button-group grid grid-cols-2 gap-4">
                            <x-link-button class="w-full py-4" href="{{ route('supplies.index') }}">Каталог товаров</x-link-button>
                            <x-link-button class="w-full py-4" href="{{ route('stores.index') }}">Список торговых точек</x-link-button>
                            <x-link-button class="w-full py-4" href="{{ route('statistic') }}">Статистика</x-link-button>
                            <x-link-button class="w-full py-4" href="{{ route('providers.index') }}">Список поставщиков</x-link-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
