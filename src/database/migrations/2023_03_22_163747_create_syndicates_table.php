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
        Schema::connection('syndicates')->create('syndicates', function (Blueprint $table) {

            $table->uuid('id_')->primary();
            $table->string('name_');
            $table->foreignId('syndicate_category_id')->references('id')->on('syndicate_categories');
            $table->foreignId('syndicate_type_id')->references('id')->on('syndicate_types');
            $table->string('ref_str_sts_code_', 1)->default('N');
            $table->string('id_no')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_restricted')->default(0);
            $table->string('city_code_')->nullable();
            $table->string('region_code')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('since');
            $table->integer('created_by');
            $table->timestamp('create_dt')->nullable();
            $table->timestamp('update_dt')->nullable();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('syndicates')->dropIfExists('profiles');
    }
};
