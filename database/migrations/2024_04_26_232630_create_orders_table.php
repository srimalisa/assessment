<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->integer('restaurant_id');
            $table->string('payment_id')->nullable();
            $table->integer('user_id');
            $table->integer('delivery_id');
            $table->string('description');
            $table->double('total_price', 10, 2)->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->integer('order_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
}
