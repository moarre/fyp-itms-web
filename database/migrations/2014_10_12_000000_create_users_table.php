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
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('fullname')->nullable();
            $table->string('ic')->nullable();
            $table->integer('student_number')->nullable();
            $table->string('address')->nullable();
            $table->string('nama_penjaga')->nullable();
            $table->string('alamat_penjaga')->nullable();
            $table->string('phone_penjaga')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('coordinator_id')->nullable();
            $table->unsignedBigInteger('lecturer_id')->nullable();
            $table->unsignedBigInteger('interndata_id')->nullable();
            $table->unsignedBigInteger('li01_id')->nullable();
            $table->unsignedBigInteger('li02_id')->nullable();
            $table->unsignedBigInteger('li03_id')->nullable();
            $table->unsignedBigInteger('li04_id')->nullable();
            $table->rememberToken();
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
