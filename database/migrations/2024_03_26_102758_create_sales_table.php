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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->dateTime('sale_date')->nullable();
            $table->decimal('total_sale', 10, 2);
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->string('registered_by')->nullable();
            $table->string('route')->nullable();

            
           
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
