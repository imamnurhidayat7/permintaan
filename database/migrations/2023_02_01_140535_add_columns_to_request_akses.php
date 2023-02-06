<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRequestAkses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_akses', function (Blueprint $table) {
            $table->text('nda')->nullable();
            $table->text('keperluan')->nullable();
            $table->text('hak_akses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_akses', function (Blueprint $table) {
            $table->dropColumn('nda');
            $table->dropColumn('keperluan');
            $table->dropColumn('hak_akses');
        });
    }
}
