<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Orders;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'role',
        'email_verified_at',
        'is_active',
        'phone',
        'remmember_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Role checking methods
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManagePaymentAccounts(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageOrders(): bool
    {
        return $this->hasRole('admin', 'super_admin');
    }

    // Relationships
    public function userAdresses()
    {
        return $this->hasMany(UserAdresses::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function returns()
    {
        return $this->hasMany(Returns::class);
    }

    public function processedReturns()
    {
        return $this->hasMany(Returns::class, 'processed_by');
    }

    public function verifiedPayments()
    {
        return $this->hasMany(Payments::class, 'verified_by');
    }

    public function carts()
    {
        return $this->hasMany(Carts::class);
    }

}
