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
        Schema::create('NOTES', function (Blueprint $table) {
            $table->uuid('ID_')->primary();
            $table->longText('DESCRIPTION');
            $table->foreignUuid('SYNDICATE_ID_')->references('ID_')->on('syndicates');
            $table->integer('CREATED_BY',false,true);
            $table->timestamp('INSERT_DT')->nullable();
            $table->timestamp('CREATE_DT')->nullable();
            $table->timestamp('UPDATE_DT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('NOTES');
    }
};
