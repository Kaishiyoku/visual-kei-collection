<x-app-layout>
    <x-slot name="header">
        <x-page-header.flex-container>
            <x-page-header.container>
                <x-page-header.back-link :href="route('artists.index')"/>

                <div>
                    <x-page-header.headline>
                        {{ __('artist.edit', ['name' => $artist->name]) }}
                    </x-page-header.headline>

                    <div>{{ trans_choice('artist.number_of_images', $artist->images_count) }}</div>
                </div>
            </x-page-header.container>

            <x-delete-button :action="route('artists.destroy', $artist)"/>
        </x-page-header.flex-container>
    </x-slot>

    {{ html()->modelForm($artist, 'put', route('artists.update', $artist))->class('px-4 sm:px-0')->open() }}
        @include('artist._form_fields')

        <x-jet-button>{{ __('Save') }}</x-jet-button>
    {{ html()->closeModelForm() }}
</x-app-layout>
