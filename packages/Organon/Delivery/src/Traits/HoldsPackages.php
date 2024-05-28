<?php

namespace Organon\Delivery\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Organon\Delivery\Models\PackageTransaction;

trait HoldsPackages
{
    public function packageTransactions(): MorphMany
    {
        return $this->morphMany(PackageTransaction::class, 'holder');
    }

    public function currentPackageTransactions(): MorphMany
    {
        return $this->packages()->whereNull('until');
    }
}
