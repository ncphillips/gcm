<?php

namespace Tests\Aggregates;

use App\Aggregates\Attribute;
use App\StorableEvents\AttributeInitialized;
use App\StorableEvents\PointsAddedToAttribute;
use App\StorableEvents\PointsRemovedFromAttribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{

    public function test_initializing_attribute()
    {
        $characterUuid = '1234';
        $attrId = 'st';
        $costPerLevel = 10;
        $startingPoints = 0;
        $startingLevel = 10;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->when(fn(Attribute $attribute) => $attribute->initialize($characterUuid, $attrId, $costPerLevel))
            ->assertRecorded(new AttributeInitialized($characterUuid, $attrId, $costPerLevel))
            ->aggregateRoot();

        $this->assertEquals($characterUuid, $attribute->characterUuid);
        $this->assertEquals($attrId, $attribute->attrId);
        $this->assertEquals($costPerLevel, $attribute->costPerLevel);
        $this->assertEquals($startingLevel, $attribute->level);
        $this->assertEquals($startingPoints, $attribute->points);
    }

    public function test_add_points_equivalent_to_one_level()
    {
        $costPerLevel = 10;
        $points = $costPerLevel;
        $expectedLevel = 10 + 1;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->given(new AttributeInitialized('1234', 'st', $costPerLevel))
            ->when(fn(Attribute $attribute) => $attribute->addPoints($costPerLevel))
            ->assertRecorded(new PointsAddedToAttribute($points))
            ->aggregateRoot();

        $this->assertEquals($points, $attribute->points);
        $this->assertEquals($expectedLevel, $attribute->level);
    }

    public function test_add_points_equivalent_to_half_level()
    {
        $costPerLevel = 10;
        $points = $costPerLevel / 2;
        $expectedLevel = 10;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->given(new AttributeInitialized('1234', 'st', $costPerLevel))
            ->when(fn(Attribute $attribute) => $attribute->addPoints($points))
            ->assertRecorded(new PointsAddedToAttribute($points))
            ->aggregateRoot();

        $this->assertEquals($points, $attribute->points);
        $this->assertEquals($expectedLevel, $attribute->level);
    }

    public function test_remove_points_equivalent_to_two_levels()
    {
        $costPerLevel = 10;
        $points = $costPerLevel * 2;
        $expectedLevel = 10 - 2;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->given(new AttributeInitialized('1234', 'st', $costPerLevel))
            ->when(fn(Attribute $attribute) => $attribute->removePoints($points))
            ->assertRecorded(new PointsRemovedFromAttribute($points))
            ->aggregateRoot();

        $this->assertEquals(-$points, $attribute->points);
        $this->assertEquals($expectedLevel, $attribute->level);
    }
}
