@php
/* @var array<string, mixed> $storeList */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список торговых точек') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <x-link-button href="{{ route('main.menu') }}">Назад</x-link-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="w-full">
                    @if (empty($storeList))
                        <p>Список торговых точек пуст.</p>
                    @else
                        <table class="min-w-full w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Адрес</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($storeList as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['address'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['type']->label() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right w-20">
                                        <x-link-button href="{{ route('stores.edit', [$item['id']]) }}">Выбрать</x-link-button>
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
</x-app-layout>
