<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Process\Process;//ejecutar comando shell o comandos 

class ActaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Acta', function(Blueprint $table){
            $table->increments('ActaID')->unsigned()->nullable(false);//increments asigna key primary automaticamente
            $table->string('NumActa',100)->nullable(false);
            $table->date('Fecha')->nullable(false);
	});
	DB::statement("ALTER TABLE Acta CONVERT TO CHARACTER SET latin1 COLLATE latin1_spanish_ci");	
	DB::statement("ALTER TABLE Acta ADD COLUMN Contenido LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci");
	DB::statement("ALTER TABLE Acta ADD FULLTEXT search(Contenido)");

        Schema::create('ArchivoActa', function($table){
            $table->integer('ActaID')->unsigned()->nullable(false)->primary();
            $table->foreign('ActaID')->references('ActaID')->on('Acta');
        });
        DB::statement("ALTER TABLE ArchivoActa ADD PDFActa MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('Acta');
    }
}
