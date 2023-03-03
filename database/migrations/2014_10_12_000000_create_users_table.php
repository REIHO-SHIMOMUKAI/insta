<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar',50)->nullable(); //column can be empty
            $table->text('introduction')->nullable(); //column can be empty
            $table->string('password');
            $table->integer('role_id')->default(2)->comment('1:admin|2:user');

            // $table->rememberToken();
            $table->timestamps();

            //nullable - allows the column to be empty (null)
            //default - default value
            // comment - notes
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
