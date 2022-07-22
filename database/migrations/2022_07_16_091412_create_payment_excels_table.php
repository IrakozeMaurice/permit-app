<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_excels', function (Blueprint $table) {
            $table->date('Date');
            $table->string('Ref');
            $table->string('Acc');
            $table->string('Names');
            $table->string('Amount');
            $table->string('Deb_Cr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_excels');
    }
}
