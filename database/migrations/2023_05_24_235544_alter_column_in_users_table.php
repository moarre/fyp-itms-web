<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('program_id') ->references('id')-> on ('programs');
            $table->foreign('semester_id') ->references('id')-> on ('semesters');
            $table->foreign('coordinator_id') ->references('id')-> on ('coordinators');
            $table->foreign('lecturer_id') ->references('id')-> on ('lecturers');
            $table->foreign('interndata_id') ->references('id')-> on ('interndata');
            $table->foreign('li01_id') ->references('id')-> on ('pdf_files');
            $table->foreign('li02_id') ->references('id')-> on ('pdf_files');
            $table->foreign('li03_id') ->references('id')-> on ('pdf_files');
            $table->foreign('li04_id') ->references('id')-> on ('pdf_files');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->foreign('coordinator_id') ->references('id')-> on ('coordinators');
        });

        Schema::table('semesters', function (Blueprint $table) {
            $table->foreign('coordinator_id') ->references('id')-> on ('coordinators');
        });

        Schema::table('coordinators', function (Blueprint $table) {
            $table->foreign('program_id') ->references('id')-> on ('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
