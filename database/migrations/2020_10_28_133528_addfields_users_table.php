<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddfieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->string("surname")->after("name");
            $table->string("middle_name")->after("surname");
            $table->boolean("seller", 0)->nullable();
            $table->boolean("is_admin", 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("surname");
            $table->dropColumn("middle_name");
            $table->dropColumn("seller");
            $table->dropColumn("is_admin");
        });
    }
}
