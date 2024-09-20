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
        Schema::table('supplies', static function (Blueprint $table): void {
            $table->dropColumn(['store_id', 'quantity']);
            $table->rename('supply_infos');
        });

        Schema::create('supplies', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('barcode');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('supply_info_id')->constrained('supply_infos');
            $table->unique(['store_id', 'supply_info_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplies', static function (Blueprint $table): void {
            $table->drop();
        });

        Schema::table('supply_infos', static function (Blueprint $table): void {
            $table->foreignId('store_id')->constrained('stores');
            $table->unsignedBigInteger('quantity')->default(0)->nullable(false);
            $table->rename('supplies');
        });
    }
};
