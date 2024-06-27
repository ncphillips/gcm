<?php

namespace App\Models;

use App\Data\GCS\AttributeData;
use App\Data\GCS\CharacterData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $id
 * @property string $name
 * @property CharacterData $gcs_data
 */
class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gcs_data',
    ];

    protected $casts = [
        'gcs_data' => CharacterData::class,
    ];

    public function st(): AttributeData {
        return $this->attribute('st');
    }

    public function dx(): AttributeData {
        return $this->attribute('dx');
    }

    public function iq(): AttributeData {
        return $this->attribute('iq');
    }

    public function ht(): AttributeData {
        return $this->attribute('ht');
    }

    public function attribute(string $name): AttributeData {
        return collect($this->gcs_data->attributes)->first(fn(AttributeData $attribute) => $attribute->attr_id === $name);
    }
}
