<?php

namespace Database\Seeders;

use Mpob\Syndicates\Models\Relationship;
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
            ["NAME_" => "Pelesen Subahat"],
            ["NAME_" => "Ketua Sindiket"],
            ["NAME_" => "Ahli"],
            ["NAME_" => "Sindiket Subahat"]
        ];

        foreach ($data as $d){
            $model = new Relationship();
            $model->name_ = $d['name_'];
            $model->save();
        }
    }
}
