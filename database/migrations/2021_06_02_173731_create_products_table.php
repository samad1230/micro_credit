<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->collation('utf16_general_ci');
            $table->string('product_details')->nullable()->collation('utf16_general_ci');
            $table->integer('buy_price');
            $table->integer('sell_price');
            $table->string('warranty')->nullable();
            $table->string('purchase_date');
            $table->string('sell_date')->nullable()->default('0');
            $table->string('investment_no')->nullable()->default('0');
            $table->integer('member_id')->nullable()->default('0');
            $table->enum('status', array('0','1'))->default('0');
            $table->integer('user_id');
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
        Schema::dropIfExists('products');
    }
}
