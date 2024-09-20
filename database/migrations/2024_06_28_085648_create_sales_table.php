<?php

use App\Enum\SaleStatusEnum;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('store_id');
            $table->foreignId('user_id');
            $table->foreignId('customer_id')->nullable();
            $table->string('payment_method');
            $table->string('status', 4)->default(SaleStatusEnum::New->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
