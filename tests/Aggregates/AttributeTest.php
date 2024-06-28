<?php

namespace Tests\Aggregates;

use App\Aggregates\Attribute;
use App\StorableEvents\AttributeInitialized;
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

}
