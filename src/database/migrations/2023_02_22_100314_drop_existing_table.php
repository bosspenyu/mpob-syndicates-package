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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('migration');
        Schema::dropIfExists('syndicate_types');
        Schema::dropIfExists('syndicate_categories');
        Schema::dropIfExists('syndicates');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('relationships');
        Schema::dropIfExists('networks');
        Schema::dropIfExists('syndicate_tags');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('media');
        Schema::dropIfExists('notes');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syndicate_types');
    }
};
