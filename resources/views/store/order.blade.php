@php /** @var array $supplyList */ @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Оформление заявки поставщикам (' . $storeName . ')') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <x-link-button href="{{ route('stores.catalog', $storeId) }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="container">
                    <form action="{{ route('stores.store-order', $storeId) }}" method="POST">
                        @csrf
                        @method('POST')

                        <table class="min-w-full w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Наименование товара</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Стоимость</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">В наличии</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Количество</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-60">Поставщик</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($supplyList as $supply)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $supply['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $supply['price'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $supply['quantity'] }}</td>
                                    <td>
                                        <div class="py-2 mr-2">
                                            <x-text-input id="quantity[{{ $supply['id'] }}]" class="{{ empty($errors->get('quantity.'.$supply['id'])) ? '' : 'border-red-500'}} block mt-1 w-full" type="number" name="quantity[{{ $supply['id'] }}]" :value="old('quantity.'.$supply['id'], 0)"/>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="py-2">
                                            <select name="providers[{{  $supply['id']  }}]" id="providers[{{  $supply['id']  }}]"
                                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                                @foreach($supply['providers'] as $id => $provider)
                                                    <option value="{{ $id }}" {{ (int) old('providers.'.$supply['id']) === $id ? 'selected' : '' }}>{{ $provider }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('providers.'.$supply['id'])" class="mt-2"/>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <x-primary-button class="mt-4">{{ __('Сформировать заявку') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
