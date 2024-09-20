@php
use App\Enum\StoreTypeEnum;
use App\Models\Store;

/** @var Store $store */
/** @var array<StoreTypeEnum> $storeTypes */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Торговая точка ' . $store->name) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                        <x-link-button href="{{ route('stores.catalog', $store->id) }}">Товары</x-link-button>
                        <x-link-button href="{{ route('stores.index') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('stores.update', $store->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="py-2">
                        <x-input-label for="name" :value="__('Наименование')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $store->name)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="address" :value="__('Адрес')"/>
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $store->address)"
                                      required/>
                        <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="area" :value="__('Площадь')"/>
                        <x-text-input id="area" class="block mt-1 w-full" type="number" name="area" :value="old('area', $store->area)"
                                      required/>
                        <x-input-error :messages="$errors->get('area')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="type" :value="__('Тип')"/>
                        <select name="type" id="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @foreach($storeTypes as $type)
                                <option value="{{ $type->value }}" {{ old('type', $store->type) === $type ? 'selected' : '' }}>{{ $type->label() }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="utility_costs" :value="__('Стоимость обслуживания')"/>
                        <x-text-input id="utility_costs" class="block mt-1 w-full" type="number" name="utility_costs" :value="old('utility_costs', $store->utility_costs)"
                                      required/>
                        <x-input-error :messages="$errors->get('utility_costs')" class="mt-2"/>
                    </div>

                    <x-primary-button class="mt-4">{{ __('Сохранить') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
