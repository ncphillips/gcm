<?php

namespace Tests\Aggregates;

use App\Aggregates\Attribute;
use App\StorableEvents\AttributeInitialized;
use App\StorableEvents\PointsAddedToAttribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{

    public function test_initializing_attribute()
    {
        $characterUuid = '1234';
        $attr_id = 'st';
        $cost_per_point = 10;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->when(fn(Attribute $attribute) => $attribute->initialize(
                $characterUuid,
                $attr_id,
                $cost_per_point,
            ))
            ->assertRecorded(new AttributeInitialized($characterUuid, $attr_id, $cost_per_point))
            ->aggregateRoot();

        $this->assertEquals($characterUuid, $attribute->characterUuid);
        $this->assertEquals($attr_id, $attribute->attrId);
        $this->assertEquals(10, $attribute->costPerLevel);
        $this->assertEquals(10, $attribute->level);
        $this->assertEquals(0, $attribute->points);
    }

    public function test_add_points_equivalent_to_one_level()
    {
        $costPerLevel = 10;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->given(new AttributeInitialized('1234', 'st', $costPerLevel))
            ->when(fn(Attribute $attribute) => $attribute->addPoints($costPerLevel))
            ->assertRecorded(new PointsAddedToAttribute($costPerLevel))
            ->aggregateRoot();

        $this->assertEquals(10, $attribute->points);
        $this->assertEquals(11, $attribute->level);
    }

    public function test_add_points_equivalent_to_half_level()
    {
        $costPerLevel = 10;
        $points = $costPerLevel / 2;

        /** @var Attribute $attribute */
        $attribute = Attribute::fake()
            ->given(new AttributeInitialized('1234', 'st', $costPerLevel))
            ->when(fn(Attribute $attribute) => $attribute->addPoints($points))
            ->assertRecorded(new PointsAddedToAttribute($points))
            ->aggregateRoot();

        $this->assertEquals($points, $attribute->points);
        $this->assertEquals(10, $attribute->level);
    }

}
