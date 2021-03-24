<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_no');
            $table->string('name')->collation('utf16_general_ci');
            $table->string('mobile');
            $table->string('father_name')->collation('utf16_general_ci');
            $table->string('mother_name')->collation('utf16_general_ci')->nullable();
            $table->string('occupation')->nullable();
            $table->string('age');
            $table->string('gender');
            $table->string('religion');
            $table->string('marital_status')->nullable();
            $table->longText('present_address');
            $table->longText('permanent_address')->nullable();
            $table->string('join_date');
            $table->string('status');
            $table->string('user_id');
            $table->string('slag');
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
        Schema::dropIfExists('members');
    }
}
