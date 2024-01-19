<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Mpob\Syndicates\Models\Relationship;
use Mpob\Syndicates\Models\SyndicateCategory;
use Mpob\Syndicates\Models\SyndicateType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //avoid error when to truncate data by SET FK Check
        DB::connection(config('syndicates.syndicates'))->statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(SyndicateCategorySeeder::class);
        $this->call(SyndicateTypeSeeder::class);
        $this->call(RelationshipSeeder::class);

        //Set FK Check
        DB::connection(config('syndicates.syndicates'))->statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
