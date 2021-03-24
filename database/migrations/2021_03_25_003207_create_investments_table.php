<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('investment_no');
            $table->string('investment_type_id');
            $table->string('investment_behaviour');
            $table->float('investment_amount');
            $table->integer('installment_count');
            $table->float('downpayment')->nullable();
            $table->float('savings_per_installment')->nullable();
            $table->float('interest_rate');
            $table->float('investment_return_amount');
            $table->float('installment_amount');
            $table->string('sanction_date');
            $table->string('disburse_date')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('investments');
    }
}
