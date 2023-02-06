<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_keamanan_siber', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_request')->nullable();
            $table->string('jenis',100)->nullable();
            $table->longText('pesan')->nullable();
            $table->longText('nota_dinas')->nullable();
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
        Schema::dropIfExists('request_keamanan_siber');
    }
}
