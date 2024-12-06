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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('city', 50);
            $table->string('type');
            $table->boolean('sale_type');
            $table->integer('mq');
            $table->string('cover_image')->nullable();
            $table->float('price');

            $table->tinyInteger('number_bathrooms');
            $table->tinyInteger('number_rooms');
            $table->boolean('elevator')->default(0);
            $table->boolean('garden')->default(0);
            $table->boolean('parking_space')->default(0);
            $table->boolean('balcony')->default(0);
            $table->string('energetic_effigency', 10)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
