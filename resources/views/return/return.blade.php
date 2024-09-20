<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Продажа ' . $store) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                        <form action="{{ route('sales.destroy') }}" method="POST"
                              onsubmit="return confirm('Вы уверены, что хотите удалить чек?');"
                        >
                            @csrf
                            @method('DELETE')
                            <x-secondary-button type="submit">{{ __('Отменить') }}</x-secondary-button>
                        </form>
                        <x-link-button href="{{ route('main.menu') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-2 mr-2">
                        <form action="{{ route('sales.position') }}" method="POST">
                            @csrf

                            <div class="py-2">
                                <x-input-label for="barcode" :value="__('Штрихкод')"/>
                                <x-text-input id="barcode" class="block mt-1 w-full" type="text" name="barcode" :value="old('barcode')" required autofocus/>
                                <x-input-error :messages="$errors->get('barcode')" class="mt-2"/>
                            </div>

                            <x-primary-button class="mt-4">{{ __('Добавить') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="container">
                    @if (empty($positions))
                        <p>В чеке нет товаров.</p>
                    @else
                        <table class="min-w-full w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Наименование</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Количество</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">К оплате</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-48"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($positions as $id => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['quantity'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['price'] }} ₽</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right flex justify-end">
                                        <form action="{{ route('sales.destroy-position', $id) }}" method="POST"
                                              onsubmit="return confirm('Вы уверены, что хотите удалить этот товар из чека?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <x-secondary-button type="submit">{{ __('Удалить') }}</x-secondary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-2 mr-2">
                        <form action="{{ route('sales.complete') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            @if($storeType !== 'minimarket')
                            <div class="py-2">
                                <x-input-label for="customer_id" :value="__('Покупатель')"/>
                                <select name="customer_id" id="customer_id"  class="select2 mt-1 block w-full">
                                    @foreach($customers as $id => $customer)
                                        <option value="{{ $id }}" @if($id === old('customer_id')) selected @endif>{{ $customer }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2"/>
                            </div>
                            @endif

                            <div class="py-2">
                                <x-input-label for="payment_method" :value="__('Способ оплаты')"/>

                                <div class="mt-1">
                                    <label for="payment_method_card" class="inline-flex items-center">
                                        <input type="radio" name="payment_method" id="payment_method_card" value="card" class="form-radio" checked>
                                        <span class="ml-2">{{ __('Карта') }}</span>
                                    </label>
                                </div>

                                <div class="mt-1">
                                    <label for="payment_method_cash" class="inline-flex items-center">
                                        <input type="radio" name="payment_method" id="payment_method_cash" value="cash" class="form-radio">
                                        <span class="ml-2">{{ __('Наличные') }}</span>
                                    </label>
                                </div>

                                <x-input-error :messages="$errors->get('payment_method')" class="mt-2"/>
                            </div>

                            <div class="py-2">
                                <div class="text-lg font-bold">
                                    К оплате
                                    <span class="text-2xl text-red-600">{{ $sumPrice }} ₽</span>
                                </div>
                            </div>

                            <x-primary-button class="mt-4">{{ __('Оплачено') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
