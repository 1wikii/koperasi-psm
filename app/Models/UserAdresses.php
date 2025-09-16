<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdresses extends Model
{
    protected $table = 'user_adresses';

    protected $fillable = [
        'id',
        'label',
        'recipient_name',
        'address',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
