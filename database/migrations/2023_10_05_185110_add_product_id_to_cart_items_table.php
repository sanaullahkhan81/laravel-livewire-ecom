<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->after('user_id')->nullable();
            // Add a foreign key constraint if you want
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('set null'); // or ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['product_id']);
            // Drop column
            $table->dropColumn('product_id');
        });
    }
};
