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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name');
            $table->string('customer_email');
            $table->integer('delivery_type');
            $table->integer('payment_method');

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->foreignId('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->cascadeOnDelete();

            $table->foreignId('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
