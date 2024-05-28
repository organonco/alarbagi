<?php

namespace Organon\Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Organon\Delivery\Contracts\PackageTransaction as PackageTransactionContract;
use Organon\Delivery\Interfaces\PackageHolder;

class PackageTransaction extends Model implements PackageTransactionContract
{
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'holder_id',
        'holder_type',
        'from',
        'until'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function holder()
    {
        return $this->morphTo();
    }

    public function getHolder(): PackageHolder
    {
        return $this->holder;
    }

    public function getHolderInfoAttribute()
    {
        $holder = $this->getHolder();
        return [
            'name' => $holder->getName(),
            'phone' => $holder->getPhone(),
            'type' => $holder->getType()
        ];
    }
}
