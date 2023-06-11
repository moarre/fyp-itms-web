<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterndataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interndata', function (Blueprint $table) {
            $table->id();
            $table->string('companyName')->nullable();
            $table->string('companyAddress')->nullable();
            $table->string('companyEmail')->nullable();
            $table->string('dateDuty')->nullable();
            $table->string('periodDuty')->nullable();
            $table->string('personinCharge')->nullable();
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
        Schema::dropIfExists('interndata');
    }
}
