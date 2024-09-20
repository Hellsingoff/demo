<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список поставщиков') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                        <x-link-button href="{{ route('providers.create') }}">Добавить поставщика</x-link-button>
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
                    @if (empty($providers))
                        <p>Список поставщиков пуст.</p>
                    @else
                        <table class="min-w-full w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Наименование</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Номер телефона</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($providers as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['phone'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex justify-end">
                                        <x-link-button class="mr-2" href="{{ route('providers.edit', $item['id']) }}">{{ __('Редактировать') }}</x-link-button>
                                        <form action="{{ route('providers.destroy', $item['id']) }}" method="POST"
                                              onsubmit="return confirm('Вы уверены, что хотите удалить этого поставщика?');"
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
</x-app-layout>
