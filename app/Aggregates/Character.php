<?php

namespace App\Aggregates;

use App\Data\GCS\AttributeData;
use App\StorableEvents\CharacterCreated;
use App\StorableEvents\CharacterNamed;
use App\StorableEvents\CharacterPointsSpentOnAttribute;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class Character extends AggregateRoot
{
    public string $playerUuid;
    public string $name;

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

    protected function applyCharacterCreated(CharacterCreated $event): void
    {
        $this->playerUuid = $event->playerUuid;
        $this->st = AttributeData::st();
        $this->dx = AttributeData::dx();
        $this->iq = AttributeData::iq();
        $this->ht = AttributeData::ht();
    }

    protected function applyCharacterNamed(CharacterNamed $event): void
    {
        $this->name = $event->name;
    }

    protected function applyCharacterPointsSpentOnAttribute(CharacterPointsSpentOnAttribute $event): void
    {
        $attribute = $this->{$event->attr_id};
        $attribute->calc->points += $event->points;

        $cost_per_level = match($event->attr_id) {
            'st', 'ht' => 10,
            'dx', 'iq' => 20,
        };

        $adj = $event->points / $cost_per_level;

        $attribute->adj = $adj;
        $attribute->calc->value = 10 + $adj;
    }
}
