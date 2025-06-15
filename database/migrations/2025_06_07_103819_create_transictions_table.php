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
        Schema::create('transictions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('customer_id'); // foreign key to customers table
            $table->string('details');
            $table->decimal('sellamount', 12, 2);
            $table->decimal('paymentamount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('transictions', function (Blueprint $table) {
            $table->decimal('paymentamount', 8, 2)->change();
            $table->decimal('sellamount', 8, 2)->change();
        });
    }
};
