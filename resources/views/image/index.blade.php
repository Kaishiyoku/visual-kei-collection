<x-app-layout>
    <x-slot name="header">
        <x-page-header.flex-container>
            <div>
                <x-page-header.headline>
                    {{ __('Images') }}
                </x-page-header.headline>

                <div>{{ trans_choice('image.total_number_of_images', $images->total()) }}</div>
            </div>

            <x-secondary-button-link :href="route('images.create')">{{ __('Add image') }}</x-secondary-button-link>
        </x-page-header.flex-container>
    </x-slot>

    @if ($images->isNotEmpty())
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($images as $image)
                <a href="{{ route('images.show', $image) }}" class="group block w-full h-[250px] transition sm:rounded-lg hover:opacity-70">
                    <x-card.card class="h-full overflow-hidden bg-cover transform hover:scale-105 transition ease-in-out" style="background-image: url('{{ $image->getThumbnailFilePath() }}')">
                        @if ($image->artists->isNotEmpty())
                            <x-card.body class="absolute bottom-0">
                                @include('image._artists')
                            </x-card.body>
                        @endif
                    </x-card.card>
                </a>
            @endforeach
        </div>
    @else
        <x-empty-info>
            {{ __('No images found.') }}
        </x-empty-info>
    @endif

    <div class="px-4 sm:px-0 pt-8">
        {{ $images->links() }}
    </div>
</x-app-layout>
