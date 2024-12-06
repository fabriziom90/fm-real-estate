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
        Schema::table('purchase_proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->after('id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->unsignedBigInteger('area_id')->after('id')->nullable();
            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnDelete();

            $table->integer('mq_from')->after('price_to');
            $table->integer('mq_to')->after('mq_from');
            $table->text('notes')->after('mq_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_proposals', function (Blueprint $table) {
            //
        });
    }
};
