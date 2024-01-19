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
        Schema::connection('syndicates')->create('tags', function (Blueprint $table) {
            $table->uuid('id_')->primary();
            $table->string('name_')->unique();
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('syndicates')->dropIfExists('syndicate_tags');
    }
};
