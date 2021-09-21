<?php

namespace Database\Seeders;

use App\Models\article;
use App\Models\categorie;
use Illuminate\Database\Seeder;

class articleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        categorie::create([
            'name' => 'Piéce de branchement'
        ]);

        $articles = [
            ['name' => 'Collier de prise en charge', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Conduite existante en charge', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Robinet de prise en charge vert 20', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Tabernac en PVC', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Tube allonge en PVC', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Bouse à clé', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Raccord à serage rapide en PVC 32*1', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'Tuyau en PEHD 21*32 mm', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
            ['name' => 'gaine de couteur blue', 'category_id' => 1, 'unit_id' => 1, 'notification_quantity' => 10],
        ];
        foreach ($articles as $article) {
            article::create($article);
        }
    }
}
