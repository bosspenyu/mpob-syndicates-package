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
            ["NAME" => "Warganegara"],
            ["NAME" => "Bukan Warganegara"],
            ["NAME" => "Syarikat"],
            ["NAME" => "Kumpulan"]
        ];

        foreach ($data as $d){
            $model = new SyndicateType();
            $model->name = $d['name'];
            $model->save();
        }
    }
}
