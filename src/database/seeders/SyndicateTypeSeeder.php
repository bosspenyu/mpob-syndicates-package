<?php

namespace Database\Seeders;

use Mpob\Syndicates\Models\SyndicateType;
use Illuminate\Database\Seeder;

class SyndicateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SyndicateType::truncate();
        $data = [
            ["NAME_" => "Warganegara"],
            ["NAME_" => "Bukan Warganegara"],
            ["NAME_" => "Syarikat"],
            ["NAME_" => "Kumpulan"]
        ];

        foreach ($data as $d){
            $model = new SyndicateType();
            $model->NAME_ = $d['NAME_'];
            $model->save();
        }
    }
}
