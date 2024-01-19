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
        Schema::connection('syndicates')->create('vehicles', function (Blueprint $table) {
            $table->uuid('id_')->primary();
            $table->string('reg_no');
            $table->string('vehicle_code',3);
            $table->string('make_', 3);
            $table->string('colour');
            $table->foreignUuid('syndicate_id_')->references('id_')->on('syndicates');
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('syndicates')->dropIfExists('vehicles');
    }
};
