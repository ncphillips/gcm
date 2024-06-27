<?php

namespace Tests\Aggregates\Character;

use App\Aggregates\Character;
use App\Data\GCS\AttributeData;
use App\StorableEvents\CharacterCreated;
use App\StorableEvents\CharacterNamed;
use Tests\TestCase;

class CreatingCharactersTest extends TestCase
{
    function test_sets_the_player_uuid()
    {
        // Fake UUID for players id
        $playerUuid = '1234';

        /** @var Character $character */
        $character = Character::fake()
            ->when(fn(Character $character) => $character->create(playerUuid: $playerUuid))
            ->assertRecorded(new CharacterCreated(playerUuid: $playerUuid))
            ->aggregateRoot();

        $this->assertEquals($playerUuid, $character->playerUuid);
        $this->assertEquals(AttributeData::st(), $character->st);
        $this->assertEquals(AttributeData::dx(), $character->dx);
        $this->assertEquals(AttributeData::iq(), $character->iq);
        $this->assertEquals(AttributeData::ht(), $character->ht);
    }

    function test_naming_characters()
    {
        $name = 'John Doe';

        /** @var Character $character */
        $character = Character::fake()
            ->given(new CharacterCreated(playerUuid: '1234'))
            ->when(fn(Character $character) => $character->setName($name))
            ->assertRecorded(new CharacterNamed(name: $name))
            ->aggregateRoot();

        $this->assertEquals($name, $character->name);
    }
}
