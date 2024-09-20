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
        Schema::table('provider_supply', static function (Blueprint $table): void {
            $table->renameColumn('supply_id', 'supply_info_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_supply', static function (Blueprint $table): void {
            $table->renameColumn('supply_info_id', 'supply_id');
        });
    }
};
