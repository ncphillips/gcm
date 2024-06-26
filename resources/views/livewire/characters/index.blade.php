@php use App\Models\Character; @endphp
<x-section first="true">
    <x-h1 class="mb-4">Characters ({{ $characters->count() }})</x-h1>
    <ul class="flex flex-col gap-2">
        @foreach ($characters as $character)
            <li>
                <a href="{{ route('characters.show', [$character->id]) }}">
                    {{ $character->name }}
                </a>
            </li>
        @endforeach
    </ul>
</x-section>