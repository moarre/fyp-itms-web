<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterBinaryColumnInPdfFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("alter table pdf_files modify li01 mediumblob");
        DB::statement("alter table pdf_files modify li02 mediumblob");
        DB::statement("alter table pdf_files modify li03 mediumblob");
        DB::statement("alter table pdf_files modify li04 mediumblob");
        DB::statement("alter table emaildocs modify BLI04 mediumblob");
        DB::statement("alter table emaildocs modify Lampiran1 mediumblob");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pdf_files', function (Blueprint $table) {
            //
        });
    }
}
