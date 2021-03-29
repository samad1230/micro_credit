<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentReturnInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_return_installments', function (Blueprint $table) {
            $table->id();
            $table->integer('investment_id');
            $table->string('date');
            $table->string('voucher_no');
            $table->float('installment_amount');
            $table->float('collection_amount')->nullable();
            $table->float('rest_amount');
            $table->float('installment_profit');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('investment_return_installments');
    }
}
