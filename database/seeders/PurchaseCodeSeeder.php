<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PurchaseCode;

class PurchaseCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchaseCodes = [
            [
            'purchase_code' => 'ABCDEFGH12345678',
            'activated' => false,
            'activation_date' => null,
            'expires_at' => now()->addYear(),
            ],
            [
            'purchase_code' => 'IJKLMNOP56789012',
            'activated' => false,
            'activation_date' => null,
            'expires_at' => now()->addMonths(6),
            ],
        ];

        foreach ($purchaseCodes as $code) {
            PurchaseCode::create($code);
        }
    }
}
