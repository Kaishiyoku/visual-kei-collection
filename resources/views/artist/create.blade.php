<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            {{ __('Add artist') }}
        </x-page-header.container>
    </x-slot>

    {{ html()->modelForm($artist, 'post', route('artists.store'))->class('px-4 sm:px-0')->open() }}
        @include('artist._form_fields')

        <x-jet-button>{{ __('Save') }}</x-jet-button>
    {{ html()->closeModelForm() }}
</x-app-layout>
