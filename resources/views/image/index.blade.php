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
        <div class="grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach ($images as $image)
                <a href="{{ route('images.show', $image) }}" class="group block transition sm:rounded-lg hover:opacity-70">
                    <x-card.card class="h-full overflow-hidden">
                        <div class="pb-2">
                            <img src="/{{ $image->getFilePath() }}" alt="{{ $image->id }}" height="{{ $image->height }}" class="h-full object-cover transform group-hover:scale-110 transition ease-in-out" loading="lazy"/>
                        </div>
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
