<x-badge-container>
    @foreach ($image->artists as $artist)
        <x-badge>{{ $artist->name }}</x-badge>
    @endforeach
</x-badge-container>
