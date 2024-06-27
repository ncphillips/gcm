<div class="font-sans">
    <details>
        <summary class="list-none">
            <div class="text-xl font-bold cursor-pointer">{{ $character->name }}</div>
        </summary>
        <div class="border rounded border-teal-900 my-2 p-2">
            <div class="text-teal-900">Badger Demon</div>
            <div class="mt-2 flex justify-between ">
                <span>Nolan Phillips</span>
                <span>150 Points</span>
            </div>
        </div>
    </details>

    <!-- Primary Attributes -->
    <div class="mt-1 grid grid-cols-4 gap-1">
        @foreach([
            ['name' => 'ST', 'level' => $character->st()->calc->value],
            ['name' => 'DX', 'level' => $character->dx()->calc->value],
            ['name' => 'IQ', 'level' => $character->iq()->calc->value],
            ['name' => 'HT', 'level' => $character->ht()->calc->value],
        ] as $attribute)
            <div class="flex flex-col text-center">
                <span>{{ $attribute['name']}}</span>
                <span class="text-2xl">{{ $attribute['level']}}</span>
            </div>
        @endforeach
    </div>

    <hr class="my-4"/>

    <!-- Secondary Attributes -->

    <h2 class="text-2xl font-bold mb-2">Secondary Attributes</h2>

    <div class="gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach([
            ['name' => 'Will', 'level' => $character->attribute('will')->calc->value],
            ['name' => 'Perception (Per)', 'level' => $character->attribute('per')->calc->value],
            ['name' => 'Vision', 'level' => $character->attribute('vision')->calc->value],
            ['name' => 'Hearing', 'level' => $character->attribute('hearing')->calc->value],
            ['name' => 'Taste & Smell', 'level' => $character->attribute('taste_smell')->calc->value],
            ['name' => 'Touch', 'level' => $character->attribute('touch')->calc->value],
            ['name' => 'Basic Speed', 'level' => $character->attribute('basic_speed')->calc->value],
            ['name' => 'Basic Move', 'level' => $character->attribute('basic_move')->calc->value],
        ] as $attribute)
            <div class="flex justify-between gap-2 bg-slate-200 rounded px-2">
                <span class="text-2xl">{{ $attribute['name'] }}</span>
                <span class="text-2xl">{{ $attribute['level'] }}</span>
            </div>
        @endforeach
    </div>

    <hr class="my-4"/>

    <h2 class="text-2xl font-bold mb-2">Skills</h2>
    <x-skill-list :skills="$character->gcs_data->skills"/>
</div>