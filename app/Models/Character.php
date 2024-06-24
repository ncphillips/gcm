<?php

namespace App\Models;

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
}
