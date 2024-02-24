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
        Schema::create('NETWORKS', function (Blueprint $table) {
            $table->foreignUuid('RELATIONSHIP_ID')->references('id_')->on('relationships');
            $table->uuidMorphs('FROM');
            $table->uuidMorphs('TO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('NETWORKS');
    }
};
