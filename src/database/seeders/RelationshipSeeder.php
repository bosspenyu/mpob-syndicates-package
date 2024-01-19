<?php

namespace Database\Seeders;

use App\Models\Relationship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Relationship::truncate();
        $data = [
            ["name_" => "Pelesen Subahat"],
            ["name_" => "Ketua Sindiket"],
            ["name_" => "Ahli"],
            ["name_" => "Sindiket Subahat"]
        ];

        foreach ($data as $d){
            $model = new Relationship();
            $model->name_ = $d['name_'];
            $model->save();
        }
    }
}
