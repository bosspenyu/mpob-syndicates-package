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
        Schema::create('SYNDICATE_TYPES', function (Blueprint $table) {
            $table->id();
            $table->string('NAME');//warganegara, Bukan Warga Negara, melayu, cina, india, campuran
            $table->timestamp('CREATE_DT')->nullable();
            $table->timestamp('UPDATE_DT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SYNDICATE_TYPES');
    }
};
