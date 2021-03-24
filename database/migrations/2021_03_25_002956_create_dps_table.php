<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dps', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('dps_type');
            $table->integer('dps_no');
            $table->integer('dps_amount');
            $table->integer('dps_profit');
            $table->integer('total_amount');
            $table->integer('dps_windrow');
            $table->integer('dps_blanch');
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
        Schema::dropIfExists('dps');
    }
}
