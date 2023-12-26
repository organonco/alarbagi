<?php

namespace Organon\Marketplace\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasTypeTrait
{
    public static abstract function getTypeEnum(): string;

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => static::getTypeFromValue($value),
            set: fn($value) => $this->set($value)
        );
    }


    public function setType($type)
    {
        $this->type = $type;
        $this->save();
    }


    private function set($type)
    {
        return $type->value;
    }

    public static function getTypeFromValue($value)
    {
        return static::getTypeEnum()::from($value);
    }
}