<?php

namespace Tests\Aggregates\Character;

use App\Aggregates\Character;
use App\Data\GCS\AttributeData;
use App\StorableEvents\CharacterCreated;
use App\StorableEvents\CharacterNamed;
use App\StorableEvents\CharacterPointsSpentOnAttribute;
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
        $this->assertEquals(150, $character->points);
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

    function test_add_level_to_attribute()
    {
        /** @var Character $character */
        $character = Character::fake()
            ->given([new CharacterCreated(playerUuid: '1234')])
            ->when(fn(Character $character) => $character->addPointsToAttribute('st', 10))
            ->assertRecorded(new CharacterPointsSpentOnAttribute(attr_id: 'st', points: 10))
            ->aggregateRoot();

        $this->assertEquals(AttributeData::from([
            'attr_id' => 'st',
            'adj' => 1,
            'calc' => [
                'value' => 11,
                'points' => 10,
            ],
        ]), $character->st);
        $this->assertEquals(140, $character->points);
    }

    function test_add_half_level_to_attribute()
    {
        /** @var Character $character */
        $character = Character::fake()
            ->given([new CharacterCreated(playerUuid: '1234')])
            ->when(fn(Character $character) => $character->addPointsToAttribute('dx', 5))
            ->assertRecorded(new CharacterPointsSpentOnAttribute(attr_id: 'dx', points: 5))
            ->aggregateRoot();

        $this->assertEquals(AttributeData::from([
            'attr_id' => 'dx',
            'adj' => 0,
            'calc' => [
                'value' => 10,
                'points' => 5,
            ],
        ]), $character->dx);
        $this->assertEquals(145, $character->points);
    }
}
