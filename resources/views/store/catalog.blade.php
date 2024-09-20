<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Каталог товаров ' . $nameStore) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                        <div>
                            <x-link-button href="{{ route('stores.order', $storeId) }}">Сформировать заявку</x-link-button>
                            <x-link-button href="{{ route('stores.acceptance', $storeId) }}">Прием товаров</x-link-button>
                            <x-link-button href="{{ route('stores.move-supplies', $storeId) }}">Передача товаров</x-link-button>
                            <x-link-button href="{{ route('stores.write-off-supplies', $storeId) }}">Списание товаров</x-link-button>
                        </div>
                        <x-link-button href="{{ route('stores.edit', $storeId) }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="alert-success" class="pb-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{!! session('success') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button type="button" onclick="document.getElementById('alert-success').style.display='none'">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 5.652a1 1 0 00-1.415 0L10 8.586 7.066 5.652a1 1 0 00-1.415 1.415L8.586 10l-2.935 2.934a1 1 0 101.415 1.415L10 11.414l2.934 2.935a1 1 0 001.415-1.415L11.414 10l2.934-2.934a1 1 0 000-1.415z"/>
                    </svg>
                </button>
            </span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error" class="pb-8 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <button type="button" onclick="document.getElementById('alert-error').style.display='none'">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M14.348 5.652a1 1 0 00-1.415 0L10 8.586 7.066 5.652a1 1 0 00-1.415 1.415L8.586 10l-2.935 2.934a1 1 0 101.415 1.415L10 11.414l2.934 2.935a1 1 0 001.415-1.415L11.414 10l2.934-2.934a1 1 0 000-1.415z"/>
                    </svg>
                </button>
            </span>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="container">
                    @if (empty($supplies))
                        <p>В торговой точке нет товаров.</p>
                    @else
                        <table class="min-w-full w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Наименование</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Стоимость</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Описание</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Количество</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($supplies as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['price'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['description'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['quantity'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
