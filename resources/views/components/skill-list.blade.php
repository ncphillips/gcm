@props([
    /** @var \App\Data\GCS\SkillData[]*/
    'skills'
])

<div class="flex flex-col gap-2">
    @foreach($skills ?? [] as $skill)
        @if($skill->isContainer())
            <details>
                <summary>{{$skill->name}}</summary>
                <div class="pl-4">

                    <x-skill-list :skills="$skill->children"/>
                </div>
            </details>
        @else
            <div class="flex justify-between gap-2">
                <span class="text-2xl">{{ $skill->name }}</span>
                <span class="text-2xl">{{ $skill->calc->level }} ({{ $skill->calc->rsl }})</span>
            </div>
        @endif
    @endforeach
</div>