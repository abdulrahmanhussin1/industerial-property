<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = [
            'هندسي',
            'صناعي',
            'كيميائي',
            'غذائي ودوائي',
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::create([
                'name' => $type,
                'status' => 'active',
                'created_by' => 1, // Assuming user with ID 1 exists
                'updated_by' => 1, // Assuming user with ID 1 exists
            ]);
        }
    }
}
