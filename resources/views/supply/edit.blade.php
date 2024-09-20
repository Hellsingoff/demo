@php use App\Models\SupplyInfo; @endphp
@php
/**
 * @var SupplyInfo $supply
 * @var int[] $supplyProviders
 */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактировать товар') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <x-link-button href="{{ route('supplies.index') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('supplies.update', $supply->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="py-2">
                        <x-input-label for="name" :value="__('Наименование')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      :value="old('name') ?? $supply->name"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="price" :value="__('Стоимость')"/>
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                      :value="old('price') ?? $supply->price"
                                      required/>
                        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="barcode" :value="__('Штрихкод')"/>
                        <x-text-input id="barcode" class="block mt-1 w-full" type="number" name="barcode"
                                      :value="old('barcode') ?? $supply->barcode"
                                      required/>
                        <x-input-error :messages="$errors->get('barcode')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="providers" :value="__('Провайдеры')"/>
                        <select name="providers[]" id="providers"  class="select2 mt-1 block w-full">
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}"
                                        @if(in_array($provider->id, old('providers') ?? $supplyProviders)) selected @endif>{{ $provider->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('providers')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="description" :value="__('Описание')"/>
                        <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                                      :value="old('description') ?? $supply->description"
                                      required/>
                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    </div>

                    <x-primary-button class="mt-4">{{ __('Сохранить') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
