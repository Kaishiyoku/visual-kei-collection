<x-app-layout>
    <x-slot name="header">
        <x-page-header.flex-container>
            <x-page-header.headline>
                {{ __('Artists') }}
            </x-page-header.headline>

            <x-secondary-button-link :href="route('artists.create')">{{ __('Add artist') }}</x-secondary-button-link>
        </x-page-header.flex-container>
    </x-slot>

    @if ($artists->isNotEmpty())
        <x-card.card class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($artists as $artist)
                <a class="group block md:flex md:justify-between md:space-x-4 px-4 py-3 transition first:rounded-t-md last:rounded-b-md hover:bg-gray-50 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('artists.edit', $artist) }}">
                    <div>{{ $artist->name }}</div>
                    <div class="dark:group-hover:text-gray-400 text-muted">{{ trans_choice('artist.number_of_images', $artist->images_count) }}</div>
                </a>
            @endforeach
        </x-card.card>
    @else
        <x-empty-info>
            {{ __('No artists found.') }}
        </x-empty-info>
    @endif
</x-app-layout>
