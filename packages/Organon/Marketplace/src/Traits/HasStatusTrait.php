<?php

namespace Organon\Marketplace\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Organon\Marketplace\Enums\SellerOrderStatusEnum;
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
            set: fn ($value) => $this->setStatus($value)
        );
    }

    public function setStatus($status)
    {
        $enumClass = static::getStatusEnum();
        return $status->value;
        throw new InvalidStatusException();
    }

    public static function getStatusFromValue($value)
    {
        return static::getStatusEnum()::from($value);
    }
}