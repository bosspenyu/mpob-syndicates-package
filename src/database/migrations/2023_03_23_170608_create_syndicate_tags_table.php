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
        Schema::create('SYNDICATE_TAGS', function (Blueprint $table) {
            $table->foreignUuid('TAG_ID_')->references('ID_')->on('TAGS');
            $table->foreignUuid('SYNDICATE_ID_')->references('ID_')->on('SYNDICATES');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SYNDICATE_TAGS');
    }
};
