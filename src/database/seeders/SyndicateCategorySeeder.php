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
            ["NAME_" => "Berkumpulan"],
            ["NAME_" => "Sendirian"]
        ];

        foreach ($data as $d){
            $model = new SyndicateCategory();
            $model->NAME_ = $d['NAME_'];
            $model->save();
        }
    }
}
