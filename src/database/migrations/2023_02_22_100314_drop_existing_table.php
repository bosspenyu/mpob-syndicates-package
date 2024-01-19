<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection(config('syndicates.syndicates'))->disableForeignKeyConstraints();
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('migration');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('syndicate_types');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('syndicate_categories');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('syndicates');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('tags');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('relationships');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('networks');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('syndicate_tags');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('vehicles');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('media');
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('notes');

        Schema::connection(config('syndicates.syndicates'))->enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('syndicates.syndicates'))->dropIfExists('syndicate_types');
    }
};
