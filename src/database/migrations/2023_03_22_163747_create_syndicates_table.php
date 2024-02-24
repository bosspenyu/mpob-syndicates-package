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
        Schema::create('SYNDICATES', function (Blueprint $table) {

            $table->uuid('ID_')->primary();
            $table->string('NAME_');
            $table->foreignId('SYNDICATE_CATEGORY_ID')->references('id')->on('syndicate_categories');
            $table->foreignId('SYNDICATE_TYPE_ID')->references('id')->on('syndicate_types');
            $table->string('REF_STR_STS_CODE_', 1)->default('N');
            $table->string('ID_NO')->nullable();
            $table->boolean('STATUS')->default(1);
            $table->boolean('IS_RESTRICTED')->default(0);
            $table->string('CITY_CODE_')->nullable();
            $table->string('REGION_CODE')->nullable();
            $table->decimal('LATITUDE', 11, 8)->nullable();
            $table->decimal('LONGITUDE', 11, 8)->nullable();
            $table->integer('SINCE');
            $table->integer('CREATED_BY');
            $table->timestamp('CREATE_DT')->nullable();
            $table->timestamp('UPDATE_DT')->nullable();
            $table->softDeletes('DELETED_DT');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SYNDICATES');
    }
};
