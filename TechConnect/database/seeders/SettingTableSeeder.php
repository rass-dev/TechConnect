<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'description' => "TechConnect  is a Laravel-based e-commerce platform for electronics and gadget accessories. It allows customers to browse products, place orders, and receive PDF receipts via email. Administrators can manage inventory, monitor sales, and generate reports efficiently, ensuring a responsive and accessible experience across devices.",
            'short_des'   => "TechConnect  provides a seamless online shopping experience for gadget accessories, featuring product browsing, secure checkout, order tracking, and inventory management.",
            'photo'       => "TechConnect _banner.jpg",
            'logo'        => "TechConnect _logo.jpg",
            'address'     => "Q23J+R9M, Congressional Rd Ext, Caloocan, Metro Manila, Philippines",
            'email'       => "support@TechConnect .com",
            'phone'       => "+63 912 345 6789",
        ];

        DB::table('settings')->insert($data);
    }
}
