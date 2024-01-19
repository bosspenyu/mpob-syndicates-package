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
        Schema::connection('syndicates')->disableForeignKeyConstraints();
        Schema::connection('syndicates')->dropIfExists('migration');
        Schema::connection('syndicates')->dropIfExists('syndicate_types');
        Schema::connection('syndicates')->dropIfExists('syndicate_categories');
        Schema::connection('syndicates')->dropIfExists('syndicates');
        Schema::connection('syndicates')->dropIfExists('tags');
        Schema::connection('syndicates')->dropIfExists('relationships');
        Schema::connection('syndicates')->dropIfExists('networks');
        Schema::connection('syndicates')->dropIfExists('syndicate_tags');
        Schema::connection('syndicates')->dropIfExists('vehicles');
        Schema::connection('syndicates')->dropIfExists('media');
        Schema::connection('syndicates')->dropIfExists('notes');

        Schema::connection('syndicates')->enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('syndicates')->dropIfExists('syndicate_types');
    }
};
