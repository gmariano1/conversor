<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacao', function (Blueprint $table) {

            $table->id();
            $table->char('moeda_conversora');
            $table->char('moeda_convertida');
            $table->float('valor_conversor');
            $table->float('valor_convertido');
            $table->timestamps();

            //$table->unsignedBigInteger('user_id');
            //$table->foreign('user_id')
            //    ->references('id')
              //  ->on('users')
                //->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotacao');
    }
}
