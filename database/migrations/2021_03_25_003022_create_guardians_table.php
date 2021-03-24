<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('name')->collation('utf16_general_ci');
            $table->string('father_name')->collation('utf16_general_ci');
            $table->string('phone');
            $table->string('nid_no');
            $table->string('relational_status')->collation('utf16_general_ci');
            $table->longText('present_address')->collation('utf16_general_ci');
            $table->longText('permanent_address')->collation('utf16_general_ci')->nullable();
            $table->string('investment_for')->nullable();
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
        Schema::dropIfExists('guardians');
    }
}
