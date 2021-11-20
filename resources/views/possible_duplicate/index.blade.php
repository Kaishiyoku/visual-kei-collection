<x-app-layout>
    <x-slot name="header">
        <x-page-header.container>
            <x-page-header.headline>
                {{ __('Possible duplicates') }}
            </x-page-header.headline>
        </x-page-header.container>

        <div>{{ trans_choice('possible_duplicate.total_number_of_possible_duplicates', $totalImageCount) }}</div>
    </x-slot>

    @if ($possibleDuplicates->isNotEmpty())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($possibleDuplicates as $possibleDuplicate)
                <a href="{{ route('possible_duplicates.show', $possibleDuplicate) }}" class="block transition sm:rounded-lg hover:opacity-70">
                    <x-card.card class="h-full overflow-hidden">
                        <x-card.body class="flex h-full transform hover:scale-110 transition ease-in-out">
                            <img src="{{ $possibleDuplicate->imageLeft->getFilePath() }}" alt="{{ $possibleDuplicate->imageLeft->id }}" class="max-w-[49%] h-full object-cover mr-[2%]" loading="lazy"/>
                            <img src="{{ $possibleDuplicate->imageRight->getFilePath() }}" alt="{{ $possibleDuplicate->imageRight->id }}" class="max-w-[49%] h-full object-cover" loading="lazy"/>
                        </x-card.body>
                    </x-card.card>
                </a>
            @endforeach
        </div>

        <div class="px-4 sm:px-0 pt-8">
            {{ $possibleDuplicates->links() }}
        </div>
    @else
        <x-empty-info>
            {{ __('No possible duplicates found.') }}
        </x-empty-info>
    @endif
</x-app-layout>
