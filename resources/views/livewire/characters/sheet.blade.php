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
            ['name' => 'ST', 'level' => 10],
            ['name' => 'DX', 'level' => 10],
            ['name' => 'IQ', 'level' => 10],
            ['name' => 'HT', 'level' => 10],
        ] as $attribute)
            <div class="flex flex-col text-center">
                <span>{{ $attribute['name'] }}</span>
                <span class="text-2xl">{{ $attribute['level']}}</span>
            </div>
        @endforeach
    </div>

    <hr class="my-4"/>

    <!-- Secondary Attributes -->
    <details>
        <summary class="list-none">
            <div class="text-xl font-bold cursor-pointer">Secondary Attributes</div>
        </summary>

        <div class="flex flex-col gap-2">
            @foreach([
                ['name' => 'Will', 'level' => 10],
                ['name' => 'Perception (Per)', 'level' => 10],
                ['name' => 'Vision', 'level' => 5],
                ['name' => 'Hearing', 'level' => '6-7'],
                ['name' => 'Taste & Smell', 'level' => 14],
                ['name' => 'Touch', 'level' => 10],
                ['name' => 'Basic Speed', 'level' => 6.5],
                ['name' => 'Basic Move', 'level' => 6],
            ] as $attribute)
                <div class="flex justify-between">
                    <span class="text-2xl">{{ $attribute['name'] }}</span>
                    <span class="text-2xl">{{ $attribute['level'] }}</span>
                </div>
            @endforeach
        </div>
    </details>
</div>