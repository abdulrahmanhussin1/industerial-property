<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'مدينة العاشر من رمضان',
            'مدينة 6 أكتوبر',
            'القاهرة الجديدة',
            'مدينة العبور',
            'مدينة بدر',
            'مدينة السادات',
            'مدينة الشروق',
            'مدينة المستقبل',
            'مدينة العلمين الجديدة',
            'مدينة الجلالة',
        ];

        foreach ($locations as $location) {
            \App\Models\Location::create([
                'name' => $location,
                'status' => 'active',
                'created_by' => 1, // Assuming user with ID 1 exists
                'updated_by' => 1, // Assuming user with ID 1 exists
            ]);
        }
    }
}
