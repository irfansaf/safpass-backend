<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $license = [
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
        foreach ($license as $code) {
            License::create($code);
        }
    }
}
