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
        Schema::connection('syndicates')->create('syndicate_tags', function (Blueprint $table) {
            $table->foreignUuid('tag_id_')->references('id_')->on('tags');
            $table->foreignUuid('syndicate_id_')->references('id_')->on('syndicates');
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
