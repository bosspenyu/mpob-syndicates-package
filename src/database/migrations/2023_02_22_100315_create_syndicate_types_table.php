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
        Schema::connection('syndicates')->create('syndicate_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');//warganegara, Bukan Warga Negara, melayu, cina, india, campuran
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('syndicates')->dropIfExists('syndicate_types');
    }
};
