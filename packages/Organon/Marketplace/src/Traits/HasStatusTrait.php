<?php

namespace Organon\Marketplace\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Organon\Marketplace\Exceptions\InvalidStatusException;

trait HasStatusTrait
{
    public static abstract function getStatusEnum(): string;

    protected static abstract function getDefaultStatus();

    protected static function bootHasStatusTrait()
    {
        static::creating(function ($query) {
            $query->status = static::getDefaultStatus();
        });
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => static::getStatusFromValue($value),
            set: fn ($value) => $this->set($value)
        );
    }


    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }


    private function set($status)
    {
        return $status->value;
    }

    public static function getStatusFromValue($value)
    {
        return static::getStatusEnum()::from($value);
    }
}