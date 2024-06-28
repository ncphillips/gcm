<?php

namespace App\Aggregates;

use App\StorableEvents\AttributeInitialized;
use App\StorableEvents\PointsAddedToAttribute;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class Attribute extends AggregateRoot
{
    public string $characterUuid;

    public string $attrId;

    /**
     * @var int The cost per level for this attribute.
     */
    public int $costPerLevel;

    /** @var int Current level for this attribute. */
    public int $level;

    /** @var int The amount of points invested in this attribute. */
    public int $points;

    public function initialize(string $characterUuid, string $attrId, int $costPerPoint): self
    {
        $this->recordThat(new AttributeInitialized($characterUuid, $attrId, $costPerPoint));

        return $this;
    }

    public function addPoints(int $int): self
    {
        $this->recordThat(new PointsAddedToAttribute($int));

        return $this;
    }

    protected function applyAttributeInitialized(AttributeInitialized $event): void
    {
        $this->characterUuid = $event->characterUuid;
        $this->attrId = $event->attrId;
        $this->costPerLevel = $event->costPerPoint;
        $this->level = 10;
        $this->points = 0;
    }

    public function applyPointsAddedToAttribute(PointsAddedToAttribute $event): void
    {
        $this->points += $event->points;
        $this->level = ($this->points / $this->costPerLevel) + 10;
    }
}
