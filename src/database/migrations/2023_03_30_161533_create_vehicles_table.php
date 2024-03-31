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
            $table->string('REG_NO_');
            $table->string('VEHICLE_CODE_',3);
            $table->string('MAKE_', 3);
            $table->string('COLOUR_');
            $table->foreignUuid('SYNDICATE_ID_')->references('ID_')->on('SYNDICATES');
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
