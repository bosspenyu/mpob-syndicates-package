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
        Schema::create('notes', function (Blueprint $table) {
            $table->uuid('id_')->primary();
            $table->longText('description');
            $table->foreignUuid('syndicate_id_')->references('id_')->on('syndicates');
            $table->integer('created_by',false,true);
            $table->timestamp('insert_dt')->nullable();
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
