<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupons = [
            [
                'code' => 'abc123',
                'type' => 'fixed',
                'value' => 300,
                'status' => 'active',
            ],
            [
                'code' => '111111',
                'type' => 'percent',
                'value' => 10,
                'status' => 'active',
            ],
        ];

        foreach ($coupons as $coupon) {
            DB::table('coupons')->updateOrInsert(
                ['code' => $coupon['code']], // prevent duplicates
                $coupon
            );
        }
    }
}
