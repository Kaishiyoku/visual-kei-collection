<div class="mb-4">
    <x-jet-label for="source" :value="__('validation.attributes.source')"/>

    <x-jet-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source', $image->source)"/>

    <x-validation-error for="source"/>
</div>

<div class="mb-4">
    <x-jet-label for="image" :value="__('validation.attributes.image')" :required="!$image->exists"/>

    <x-file-select-button id="image" name="image" class="mt-1 w-full" :required="!$image->exists"/>

    <x-validation-error for="image"/>
</div>
