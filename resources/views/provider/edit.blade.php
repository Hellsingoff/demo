@php use App\Models\Provider; @endphp
@php
    /* @var Provider $provider */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Изменить данные о поставщике') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <x-link-button href="{{ route('providers.index') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('providers.update', $provider->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="py-2">
                        <x-input-label for="name" :value="__('Наименование')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $provider->name)"
                                      required autofocus/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="py-2">
                        <x-input-label for="phone" :value="__('Телефон')"/>
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                      :value="old('phone', $provider->phone)" required/>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>
                    <x-primary-button class="mt-4">{{ __('Сохранить') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
