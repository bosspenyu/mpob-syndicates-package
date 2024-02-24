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
        Schema::create('RELATIONSHIPS', function (Blueprint $table) {
            $table->uuid('ID_')->primary();
            $table->string('NAME_')->unique();
            $table->timestamp('CREATE_DT')->nullable();
            $table->timestamp('UPDATE_DT')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RELATIONSHIPS');
    }
};
