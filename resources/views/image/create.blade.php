<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            {{ __('Add image') }}
        </x-page-header.container>
    </x-slot>

    {{ html()->modelForm($image, 'post', route('images.store'))->class('px-4 sm:px-0')->acceptsFiles()->open() }}
        @include('image._form_fields')

        <x-jet-button>{{ __('Save') }}</x-jet-button>
    {{ html()->closeModelForm() }}
</x-app-layout>
