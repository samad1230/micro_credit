<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('savings_no');
            $table->integer('savings_amount');
            $table->integer('savings_profit');
            $table->integer('total_amount');
            $table->integer('savings_windrow');
            $table->integer('savings_blanch');
            $table->integer('status');
            $table->string('opening_date');
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
        Schema::dropIfExists('savings');
    }
}
