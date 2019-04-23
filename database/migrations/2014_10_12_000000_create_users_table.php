<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('gender')->default(2)->comment('0: female, 1: male, 2: unknown');
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->integer('status')->default(1)->comment('1: active, 0: deactive');
            $table->string('address')->nullable();
            $table->integer('type_job')->comment('1: fulltime, 0: part-time');
            $table->integer('department_id')->comment('id của phòng ban')->nullable()->unsigned;
            $table->integer('position_id')->comment('id của chức vụ')->nullable()->unsigned;
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
