@props(['name' => null, 'value' => [], 'autocompleteValues' => [], 'minChars' => 3])

<div x-data="tagInput()" class="mt-1">
    <template x-for="tag in tags">
        <input type="hidden" name="{{ $name }}[]" :value="tag"/>
    </template>

    <div class="flex flex-wrap px-4 py-2 rounded-md shadow-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :class="{ 'ring ring-indigo-200 ring-opacity-50 border-indigo-300': isFocused }">
        <template x-for="tag in tags" :key="tag">
            <div class="inline-flex items-center justify-center mr-2 my-1 text-xs font-bold leading-none text-white bg-gray-500 dark:bg-gray-700 rounded-full">
                <div class="pl-3 pr-2 py-1" x-text="tag"></div>
                <button type="button" class="h-full pl-2 pr-3 rounded-r-full hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-700" @click="tags = tags.filter((item) => (item) !== tag)">
                    <x-heroicon-o-x class="w-3 h-3"/>
                </button>
            </div>
        </template>

        <input
            @keydown.enter.prevent="addTag"
            @focusout.debounce.150="addTagOrFromDropdown"
            @keydown.backspace="removeTag"
            @focusin="isFocused = true"
            @click.away="isFocused = false"
            x-model="newTag"
            x-ref="input"
            {{ $attributes->merge(['class' => 'flex-grow min-w-[100px] outline-none dark:bg-gray-800']) }}
        />
    </div>

    <div
        x-cloak
        x-show="isDropdownVisible()"
        @click.stop=""
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mr-4 mt-2 rounded-md shadow-lg origin-top-right"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white overflow-y-auto max-h-[200px] md:min-w-[350px] md:max-w-[800px] dark:bg-gray-800 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500">
            <div x-show="len(filteredAutocompleteValues()) === 0" class="w-full px-4 py-2 text-sm leading-5 text-gray-700">
                {{ __('No entries found.') }}
            </div>

            <template x-for="autocompleteValue in filteredAutocompleteValues()" :key="autocompleteValue.label">
                <div
                    class="w-full px-4 py-2 text-sm leading-5 text-gray-700 dark:text-white cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    tabindex="0"
                    @click.stop="addTagFromDropdown(autocompleteValue.label)"
                    @keydown.enter="addTagFromDropdown(autocompleteValue.label)"
                >
                    <div x-text="autocompleteValue.label"></div>
                    <div x-text="autocompleteValue.description" class="text-xs text-gray-500"></div>
                </div>
            </template>
        </div>
    </div>
</div>

<script type="text/javascript">
    const autocompleteValues = @json($autocompleteValues);

    function tagInput() {
        return {
            tags: @json($value),
            newTag: '',
            isFocused: false,
            minChars: {{ $minChars }},
            getNewTag() {
                return this.newTag.trim();
            },
            isDropdownVisible() {
                return len(this.getNewTag()) >= this.minChars;
            },
            addTag() {
                if (this.getNewTag() !== '' && !this.tags.includes(this.getNewTag())) {
                    this.tags.push(this.getNewTag());
                    this.newTag = '';
                }
            },
            addTagOrFromDropdown() {
                const filteredAutocompleteValues = this.filteredAutocompleteValues();

                if (len(filteredAutocompleteValues) === 1) {
                    const [firstAutocompleteValue] = filteredAutocompleteValues;

                    this.newTag = firstAutocompleteValue.label;
                }

                this.addTag();
            },
            removeTag() {
                if (this.getNewTag() === '') {
                    this.tags.pop();
                }
            },
            isTagIncluded(tag) {
                return this.tags.includes(tag);
            },
            addTagFromDropdown(value) {
                this.newTag = value;

                this.addTag();

                this.isFocused = true;
                this.$refs.input.focus();
            },
            filteredAutocompleteValues() {
                if (!this.isDropdownVisible()) {
                    return [];
                }

                return autocompleteValues.filter((item) => {
                    const isTagIncluded = this.isTagIncluded(item.label);
                    const labelContainsStr = strIncludes(item.label, this.getNewTag());
                    const descriptionContainsStr = strIncludes(item.description, this.getNewTag());

                    return !isTagIncluded && (labelContainsStr || descriptionContainsStr);
                });
            }
        };
    }
</script>
