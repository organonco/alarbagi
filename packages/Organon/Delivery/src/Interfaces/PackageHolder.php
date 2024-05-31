<?php

namespace Organon\Delivery\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface PackageHolder
{
    public function packageTransactions(): MorphMany;
    public function currentPackageTransactions(): MorphMany;
    public function isForSeller(): bool;
    public function getName(): string;
    public function getType(): string;
    public function getPhone(): string;
}
