<?php

namespace Database\Seeders;

use App\Models\SyndicateType;
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
            ["name" => "Warganegara"],
            ["name" => "Bukan Warganegara"],
            ["name" => "Syarikat"],
            ["name" => "Kumpulan"]
        ];

        foreach ($data as $d){
            $model = new SyndicateType();
            $model->name = $d['name'];
            $model->save();
        }
    }
}
