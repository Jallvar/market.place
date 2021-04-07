<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('legal_information');

        Schema::create("legal_information", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("shop_id");
            $table->bigInteger("inn");
            $table->bigInteger("ogrn");
            $table->bigInteger("kpp")->nullable();
            $table->string("adress");
            $table->date("date_register");
            $table->string("name");
            $table->string("firstname");
            $table->string("surname");
            $table->string("middle_name");
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
        Schema::dropIfExists('legal_information');
    }
}
