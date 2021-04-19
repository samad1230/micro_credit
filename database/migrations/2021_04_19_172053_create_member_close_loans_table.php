<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCloseLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_close_loans', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('invest_no');
            $table->string('return_investment')->nullable();
            $table->string('investment_pay')->nullable();
            $table->integer('discount_payment')->default(0);
            $table->string('saving_close')->default(0);
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
        Schema::dropIfExists('member_close_loans');
    }
}
