<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('saving_id')->nullable();
            $table->string('dps_id')->nullable();
            $table->string('return_investment')->nullable();
            $table->string('investment_pay')->nullable();
            $table->string('rest_investment')->nullable();
            $table->string('saving_amount')->nullable();
            $table->string('dps_amount')->nullable();
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
        Schema::dropIfExists('member_accounts');
    }
}
