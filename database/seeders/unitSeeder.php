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
            ['text'=>'Article','abr'=>'Article','description'=>''],
            ['text'=>'Kilograme','abr'=>'KG','description'=>''],
            ['text'=>'Litre','abr'=>'L','description'=>''],
            ['text'=>'Mètre','abr'=>'M','description'=>''],
            ['text'=>'Pack','abr'=>'Pack','description'=>''],
        ];
        
            foreach($units as $unit)
            {
                unit::create([
                    'name'=>$unit['name'],
                    'abr'=>$unit['abr'],
                    'description'=>$unit['description'],
                ]);
            }
    }
}
