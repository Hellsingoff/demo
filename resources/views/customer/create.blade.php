<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавить покупателя') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <x-link-button href="{{ route('customers.index') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf

                    <div class="py-2">
                        <x-input-label for="name" :value="__('Имя')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="py-2">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="py-2">
                        <x-input-label for="phone" :value="__('Телефон')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="py-2">
                        <x-input-label for="number_card" :value="__('Карта лояльности')" />
                        <x-text-input id="number_card" class="block mt-1 w-full" type="text" name="number_card" :value="old('number_card')" required />
                        <x-input-error :messages="$errors->get('number_card')" class="mt-2" />
                    </div>
                    <x-primary-button class="mt-4">{{ __('Сохранить') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
