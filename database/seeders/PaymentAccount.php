<?php

namespace Database\Seeders;

use App\Models\PaymentAccounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentAccount extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentAccounts::create([
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder_name' => 'PT. Koperasi PSM',
            'is_active' => true,
        ]);
    }
}
