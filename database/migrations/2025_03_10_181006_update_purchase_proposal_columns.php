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
            $table->integer('number_rooms')->after('mq_to');
            $table->integer('number_bathrooms')->after('number_rooms');
            $table->integer('type')->after('number_bathrooms');
            $table->integer('sale_type')->after('type');
            $table->integer('elevator')->after('sale_type');
            $table->integer('garden')->after('elevator');
            $table->integer('parking_space')->after('garden');
            $table->integer('balcony')->after('parking_space');
            $table->integer('energetic_efficency')->after('balcony');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_proposal', function (Blueprint $table) {
            //
        });
    }
};
