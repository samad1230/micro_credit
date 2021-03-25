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
            $table->string('member_id');
            $table->integer('dps_type');
            $table->string('dps_no');
            $table->float('dps_installment');
            $table->float('dps_amount')->default(0);
            $table->float('dps_profit')->default(0);
            $table->float('total_amount')->default(0);
            $table->float('dps_windrow')->default(0);
            $table->float('dps_blanch')->default(0);
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
        Schema::dropIfExists('dps');
    }
}
