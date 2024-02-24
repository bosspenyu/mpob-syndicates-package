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
        Schema::create('VEHICLES', function (Blueprint $table) {
            $table->uuid('ID_')->primary();
            $table->string('REG_NO');
            $table->string('VEHICLE_CODE',3);
            $table->string('MAKE_', 3);
            $table->string('COLOUR');
            $table->foreignUuid('SYNDICATE_ID_')->references('ID_')->on('syndicates');
            $table->timestamp('CREATE_DT')->nullable();
            $table->timestamp('UPDATE_DT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VEHICLES');
    }
};
