<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('media_entity_sizes');
        Schema::dropIfExists('media_entities');

        Schema::create('media_entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('entity_class');
            $table->string('description')->nullable();
            $table->boolean('queued')->nullable();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->unsignedSmallInteger('quality')->nullable();
            $table->string('format')->nullable();
        });

        Schema::create('media_entity_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('media_entity_id')->references('id')->on('media_entities')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('description')->nullable();
            $table->boolean('gallery');
            $table->boolean('queued')->nullable();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->unsignedSmallInteger('quality')->nullable();
            $table->string('format')->nullable();
        });

        Schema::create('media_conversion_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('media_entity_conversion_id')->references('id')->on('media_entity_conversions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->unsignedSmallInteger('quality')->nullable();
            $table->string('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_conversion_sizes');
    }
};
