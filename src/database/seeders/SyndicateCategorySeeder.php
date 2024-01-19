<?php

namespace Database\Seeders;

use Mpob\Syndicates\Models\SyndicateCategory;
use Illuminate\Database\Seeder;

class SyndicateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SyndicateCategory::truncate();
        $data = [
            ["name" => "Berkumpulan"],
            ["name" => "Sendirian"]
        ];

        foreach ($data as $d){
            $model = new SyndicateCategory();
            $model->name = $d['name'];
            $model->save();
        }
    }
}
