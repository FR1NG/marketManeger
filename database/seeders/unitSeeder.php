<?php

namespace Database\Seeders;

use App\Models\unit;
use Illuminate\Database\Seeder;

class unitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['name' => 'Article', 'abr' => 'Article', 'description' => ''],
            ['name' => 'Kilograme', 'abr' => 'KG', 'description' => ''],
            ['name' => 'Litre', 'abr' => 'L', 'description' => ''],
            ['name' => 'Mètre', 'abr' => 'M', 'description' => ''],
            ['name' => 'Pack', 'abr' => 'Pack', 'description' => ''],
        ];

        foreach ($units as $unit) {
            unit::create([
                'name' => $unit['name'],
                'abr' => $unit['abr'],
                'description' => $unit['description'],
            ]);
        }
    }
}
