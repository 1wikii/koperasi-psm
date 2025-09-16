<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAccounts extends Model
{
    protected $table = 'payment_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'bank_name',
        'account_number',
        'account_holder_name',
        'is_active'
    ];


    public function payments()
    {
        return $this->hasMany(Payments::class, 'payment_method_id');
    }
}
