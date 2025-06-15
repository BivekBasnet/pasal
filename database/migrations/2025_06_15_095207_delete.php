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
        // First, clean up any orphaned transactions
        DB::statement('DELETE FROM transictions WHERE customer_id NOT IN (SELECT id FROM customers)');

        Schema::table('transictions', function (Blueprint $table) {
            // Add foreign key with cascade delete
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transictions', function (Blueprint $table) {
            // Remove the foreign key constraint in case of rollback
            $table->dropForeign(['customer_id']);
        });
    }
};
