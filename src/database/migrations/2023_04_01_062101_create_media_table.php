<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MEDIA', function (Blueprint $table) {
            $table->id();

            $table->uuidMorphs('MODEL');
            $table->uuid()->nullable()->unique();
            $table->string('COLLECTION_NAME');
            $table->string('NAME');
            $table->string('FILE_NAME');
            $table->string('MIME_TYPE')->nullable();
            $table->string('DISK');
            $table->string('CONVERSIONS_DISK')->nullable();
            $table->unsignedBigInteger('SIZE');
            $table->json('MANIPULATIONS');
            $table->json('CUSTOM_PROPERTIES');
            $table->json('GENERATED_CONVERSIONS');
            $table->json('RESPONSIVE_IMAGES');
            $table->unsignedInteger('ORDER_COLUMN')->nullable()->index();
            $table->nullableTimestamps();
        });
    }
};
