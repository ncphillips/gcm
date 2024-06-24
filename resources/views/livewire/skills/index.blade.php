<x-section first="true">
    <x-h1 class="mb-4">Skills</x-h1>
    <ul class="flex flex-col gap-2">
        @foreach ($skills as $skill)
            <li id="equipment-{{$skill->id}}"
                class="flex items-center justify-between p-1.5 border border-amber-700 rounded bg-gradient-to-br transition-colors from-amber-50 to-amber-100">

                <div>
                    <p><strong>{{ $skill->name}}</strong></p>
                </div>
                <div class="flex gap-1">
                    <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                        <strong>Difficulty:</strong> {{ $skill->difficulty}}
                    </span>
                    @if($skill->tech_level)
                        <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                            TL{{$skill->tech_level}}
                        </span>
                    @endif
                    <span class="shadow-sm shadow-amber-300 py-0.5 px-1 text-center bg-white border rounded border-amber-500">
                        {{$skill->reference}}
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
</x-section>