<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->longText('Contenido')->nullable(true);
        });
        
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
