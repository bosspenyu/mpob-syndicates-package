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
        Schema::create('syndicate_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');//berkumpulan, sendirian
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syndicate_categories');
    }
};
