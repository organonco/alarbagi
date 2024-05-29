<?php

namespace Organon\Delivery\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Organon\Delivery\Models\Package;
use Organon\Delivery\Models\PackageTransaction;

trait HoldsPackages
{
    public function packageTransactions(): MorphMany
    {
        return $this->morphMany(PackageTransaction::class, 'holder');
    }

    public function currentPackageTransactions(): MorphMany
    {
        return $this->packageTransactions()->whereNull('until');
    }

    public function allPackages()
    {
        return $this->morphToMany(Package::class, 'holder', 'package_transactions');
    }

    public function packages()
    {
        return $this->morphToMany(Package::class, 'holder', 'package_transactions')->whereNull('package_transactions.until');
    }
}
