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
            $table->string('customer_document', 20);
            $table->string('customer_documentType', 5);
            $table->string('customer_name', 80);
            $table->string('customer_surname', 80);
            $table->string('customer_email', 120);
            $table->string('customer_mobile', 40);
            $table->string('status', 20);
            $table->string('payment_status', 40);
            $table->string('shipping_status', 40);
            $table->string('total');
            $table->timestamps();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
};
