<x-section>
    <h1>Equipment</h1>
    <ul class="flex flex-col gap-2">
        @foreach ($equipment as $item)
            <li id="equipment-{{$item->id}}">
                <strong>{{ $item->description}}: </strong>
                {{ $item->value }}; {{ $item->weight }}; TL{{$item->tech_level}}
                <button wire:click="edit({{ $item->id }})">Edit</button>
                <button wire:click="delete({{ $item->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</x-section>