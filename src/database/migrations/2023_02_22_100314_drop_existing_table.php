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
        Schema::dropIfExists('MIGRATION');
        Schema::dropIfExists('SYNDICATE_TYPES');
        Schema::dropIfExists('SYNDICATE_CATEGORIES');
        Schema::dropIfExists('SYNDICATES');
        Schema::dropIfExists('TAGS');
        Schema::dropIfExists('RELATIONSHIPS');
        Schema::dropIfExists('NETWORKS');
        Schema::dropIfExists('SYNDICATE_TAGS');
        Schema::dropIfExists('VEHICLES');
        Schema::dropIfExists('MEDIA');
        Schema::dropIfExists('NOTES');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
