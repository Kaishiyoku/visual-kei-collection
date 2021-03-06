<x-app-layout>
    <x-slot name="header">
        <x-page-header.flex-container>
            <x-page-header.container>
                <x-page-header.back-link :href="route('images.index')"/>

                <x-page-header.headline>
                    {{ __('Image details') }}
                </x-page-header.headline>
            </x-page-header.container>

            <x-secondary-button-link :href="route('images.create')">{{ __('Add another image') }}</x-secondary-button-link>
        </x-page-header.flex-container>
    </x-slot>

    <x-card.card>
        <x-card.body>
            <div class="md:flex md:space-x-4">
                <a href="{{ $image->getFilePath() }}" target="_blank" class="inline-block">
                    <img src="{{ $image->getFilePath() }}" alt="{{ $image->id }}" class="max-w-[300px]"/>
                </a>

                <div>
                    <div>
                        {{ __('ID') }}:
                        {{ $image->id }}
                    </div>

                    <div>
                        {{ __('Mime type') }}:
                        {{ $image->mimetype }}
                    </div>

                    <div>
                        {{ __('File size') }}:
                        {{ formatFileSize($image->file_size) }}
                    </div>

                    <div>
                        {{ __('Image dimensions') }}:
                        {{ $image->width }}x{{ $image->height }}
                    </div>

                    <div>
                        {{ __('Source') }}:
                        {{ $image->source }}
                    </div>

                    <div>
                        {{ __('Created at') }}:
                        {{ formatDateTime($image->created_at) }}
                    </div>

                    <div>
                        {{ __('Updated at') }}:
                        {{ formatDateTime($image->updated_at) }}
                    </div>

                    @if ($image->artists->isNotEmpty())
                        <div class="py-2">
                            @include('image._artists')
                        </div>
                    @endif

                    <div class="pt-4 md:pt-0">
                        <div class="pb-2">{{ __('Identifier image') }}:</div>
                        <img src="data:{{ $image->mimetype }};base64,{{ base64_encode($image->identifier_image) }}" alt="Identifier image" class="w-[150px] h-[150px] image-rendering-none"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <x-button-link :href="route('images.edit', $image)">
                    {{ __('Edit') }}
                </x-button-link>

                <x-delete-button :action="route('images.destroy', $image)"/>
            </div>
        </x-card.body>
    </x-card.card>
</x-app-layout>
