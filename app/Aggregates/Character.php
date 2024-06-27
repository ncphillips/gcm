<?php

namespace App\Aggregates;

use App\Data\GCS\AttributeData;
use App\StorableEvents\CharacterCreated;
use App\StorableEvents\CharacterNamed;
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
}
