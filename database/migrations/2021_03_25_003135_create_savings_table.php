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
            $table->string('member_id');
            $table->string('savings_no');
            $table->float('savings_amount')->default(0);
            $table->float('savings_profit')->default(0);
            $table->float('total_amount')->default(0);
            $table->float('savings_windrow')->default(0);
            $table->float('savings_blanch')->default(0);
            $table->integer('status')->default(1);
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
