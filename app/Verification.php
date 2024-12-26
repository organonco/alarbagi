<?php

namespace App;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Webkul\Customer\Models\Customer;

class Verification extends Model
{
    use HasFactory;

    use HasUuids;
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $fillable = ['customer_id', 'code'];

    public static function createVerification(Customer $customer)
    {
        $code = rand(10000, 99999);
        $verification = self::create([
            'code' => Hash::make($code),
            'customer_id' => $customer->id,
        ]);
        return [
            'code' => $code,
            'token' => $verification->uuid
        ];
    }

    public function setAsUsed()
    {
        $this->used = true;
        $this->save();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
