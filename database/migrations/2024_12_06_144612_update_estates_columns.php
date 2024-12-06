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
        Schema::table('estates', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->after('id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            
            $table->unsignedBigInteger('area_id')->after('customer_id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            
        });
    }
};
