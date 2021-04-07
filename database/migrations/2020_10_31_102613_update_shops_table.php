<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable("shops"))
        {
            Schema::table("shops", function (Blueprint $table){
               $table->drop();
            });
        }

        Schema::create("shops", function (Blueprint $table)
        {
            $table->integer('id')->autoIncrement();
            $table->integer("user_id");
            $table->string("name_shop");
            $table->text("description");
            $table->string("logo")->nullable(true);
            $table->string("phone");
            $table->string("email");
            $table->string("site")->nullable(true);
            $table->string("city_id");
            $table->string("work_time")->nullable(true);
            $table->string("min_price")->nullable(true);
            $table->integer("rating")->default(0);
            $table->boolean("legal_information");
            $table->boolean("phone_active");
            $table->boolean("active");
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

    }
}
