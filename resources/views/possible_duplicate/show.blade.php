<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            <x-page-header.back-link :href="route('possible_duplicates.index')"/>

            <x-page-header.headline>
                {{ __('Possible duplicate') }}
            </x-page-header.headline>
        </x-page-header.container>
    </x-slot>

    <x-form-button :action="route('possible_duplicates.ignore', [$possibleDuplicate])" method="put" class="pb-4">
        {{ __('Ignore') }}
    </x-form-button>

    <div class="flex">
        <x-card.card class="w-[49%] mr-[2%]">
            <x-card.body>
                @include('possible_duplicate._image_details', ['title' => __('Left image'), 'possibleDuplicate' => $possibleDuplicate, 'image' => $possibleDuplicate->imageLeft])
            </x-card.body>
        </x-card.card>

        <x-card.card class="w-[49%]">
            <x-card.body>
                @include('possible_duplicate._image_details', ['title' => __('Right image'), 'possibleDuplicate' => $possibleDuplicate, 'image' => $possibleDuplicate->imageRight])
            </x-card.body>
        </x-card.card>
    </div>
</x-app-layout>
