<?php

namespace App\Data\GCS;

use Spatie\LaravelData\Data;

class AttributeData extends Data
{
    public function __construct(
        public string            $attr_id,
        public int               $adj,
        public AttributeCalcData $calc,
    )
    {
    }

    public static function st()
    {
        return self::from([
            'attr_id' => 'st',
            'adj' => 0,
            'calc' => [
                'value' => 10,
                'points' => 0,
            ],
        ]);
    }

    public static function dx()
    {
        return self::from([
            'attr_id' => 'dx',
            'adj' => 0,
            'calc' => [
                'value' => 10,
                'points' => 0,
            ],
        ]);
    }

    public static function iq()
    {
        return self::from([
            'attr_id' => 'iq',
            'adj' => 0,
            'calc' => [
                'value' => 10,
                'points' => 0,
            ],
        ]);
    }

    public static function ht()
    {
        return self::from([
            'attr_id' => 'ht',
            'adj' => 0,
            'calc' => [
                'value' => 10,
                'points' => 0,
            ],
        ]);
    }
}
