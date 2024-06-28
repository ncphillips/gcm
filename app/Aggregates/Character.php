<?php

namespace App\Aggregates;

use App\Data\GCS\AttributeData;
use App\StorableEvents\CharacterCreated;
use App\StorableEvents\CharacterNamed;
use App\StorableEvents\CharacterPointsReclaimedFromAttribute;
use App\StorableEvents\CharacterPointsSpentOnAttribute;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class Character extends AggregateRoot
{
    public string $playerUuid;
    public string $name;
    public int $points;

    // Primary Attributes
    public AttributeData $st;
    public AttributeData $dx;
    public AttributeData $iq;
    public AttributeData $ht;


    public function create(string $playerUuid): self
    {
        $this->recordThat(new CharacterCreated($playerUuid));

        return $this;
    }

    public function setName(string $string): self
    {
        $this->recordThat(new CharacterNamed($string));

        return $this;
    }

    public function addPointsToAttribute(string $string, int $int): self
    {
        $this->recordThat(new CharacterPointsSpentOnAttribute($string, $int));

        return $this;
    }

    public function removePointsToAttribute(string $string, int $int): self
    {
        $this->recordThat(new CharacterPointsReclaimedFromAttribute($string, $int));

        return $this;
    }

    protected function applyCharacterCreated(CharacterCreated $event): void
    {
        $this->playerUuid = $event->playerUuid;
        $this->st = AttributeData::st();
        $this->dx = AttributeData::dx();
        $this->iq = AttributeData::iq();
        $this->ht = AttributeData::ht();
        $this->points = 150;
    }

    protected function applyCharacterNamed(CharacterNamed $event): void
    {
        $this->name = $event->name;
    }

    protected function applyCharacterPointsSpentOnAttribute(CharacterPointsSpentOnAttribute $event): void
    {
        $this->points -= $event->points;

        $cost_per_level = match ($event->attr_id) {
            'st', 'ht' => 10,
            'dx', 'iq' => 20,
        };

        $attribute = $this->{$event->attr_id};
        $attribute->calc->points += $event->points;

        $new_adj = $attribute->calc->points / $cost_per_level;
        $attribute->adj = $new_adj;
        $attribute->calc->value = 10 + $new_adj;
    }

    protected function applyCharacterPointsReclaimedFromAttribute(CharacterPointsReclaimedFromAttribute $event): void
    {
        $this->points += $event->points;

        $cost_per_level = match ($event->attr_id) {
            'st', 'ht' => 10,
            'dx', 'iq' => 20,
        };

        $attribute = $this->{$event->attr_id};
        $attribute->calc->points -= $event->points;

        $new_adj = $attribute->calc->points / $cost_per_level;
        $attribute->adj = $new_adj;
        $attribute->calc->value = 10 + $new_adj;
    }
}
