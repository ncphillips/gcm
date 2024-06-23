<x-section first="true">
    <x-h1 class="mb-4">Equipment</x-h1>
    <ul class="flex flex-col gap-2">
        @foreach ($equipment as $item)
            <li id="equipment-{{$item->id}}"
                class="flex items-center justify-between p-1.5 border border-amber-700 rounded bg-gradient-to-br transition-colors from-amber-50 to-amber-100">

                <div><strong>{{ $item->description}}</strong> (${{$item->value}})</div>
                <div class="flex gap-1">
                    @if($item->weight)
                        <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                            {{ $item->weight }}
                        </span>
                    @endif
                    <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                        TL{{$item->tech_level}}
                    </span>
                    <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                        {{$item->reference}}
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
</x-section>