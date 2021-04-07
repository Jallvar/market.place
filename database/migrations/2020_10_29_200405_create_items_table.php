<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Таблица магазина. Магазин буде привязан к пользователю
        Schema::create('shops', function(Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("user_id");
            $table->string("name_shop");
            $table->string("description");
            $table->string("logo");
            $table->string("phone");
            $table->string("email");
            $table->string("site");
            $table->string("city_id");
            $table->string("work_time");
            $table->string("min_price");
            $table->integer("rating");
            $table->boolean("legal_information");
            $table->boolean("active");
            $table->timestamps();
        });

        //Страны
        Schema::create("countries", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("name");
            $table->timestamps();
        });

        //Города
        Schema::create("cities", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("name");
            $table->string("country_id");
            $table->timestamps();
        });

        //Тип организации(поставщик, завод изготовитель)
        Schema::create("types", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("name");
            $table->string("shop_id");
            $table->timestamps();
        });

        //Справочная таблица. согласно нормализации баз данных
        Schema::create("reference_types", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("type");
            $table->integer("shop_id");
            $table->timestamps();
        });

        //Обьемы поставок
        Schema::create("volumes", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("name");
            $table->string("shop_id");
            $table->timestamps();
        });

        //Справочная таблица для объемов поставок
        Schema::create("reference_volumes", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("volume");
            $table->integer("shop_id");
            $table->timestamps();
        });

        //Виды доставок (курьером, транспортной компанией)
        Schema::create("deliveries", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("name");
            $table->timestamps();
        });

        //Справочная таблица для доставок
        Schema::create("reference_deliveries", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer("delivery");
            $table->integer("shop_id");
            $table->timestamps();
        });

        //Категории товаров (включает дочернии категории)
        Schema::create("categories", function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("category_name");
            $table->string("description");
            $table->integer("parent")->nullable();
            $table->timestamps();
        });

        //Товары
        Schema::create('items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("item_name");
            $table->text('description');
            $table->integer('category_id');
            $table->integer('shop_id');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('cover');
            $table->timestamps();
        });

        //Прикрепление к товарам. Фото, документы итд
        Schema::create('attachments', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string("filename");
            $table->string("type");
            $table->string("item_id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('items'))
            Schema::drop('items');

        if(Schema::hasTable('shops'))
            Schema::drop('shops');

        if(Schema::hasTable('categories'))
            Schema::drop('categories');

        if(Schema::hasTable('countries'))
            Schema::drop('countries');

        if(Schema::hasTable('cities'))
            Schema::drop('cities');

        if(Schema::hasTable('types'))
            Schema::drop('types');

        if(Schema::hasTable('reference_types'))
            Schema::drop('reference_types');

        if(Schema::hasTable('volumes'))
            Schema::drop('volumes');

        if(Schema::hasTable('reference_volumes'))
            Schema::drop('reference_volumes');

        if(Schema::hasTable('deliveries'))
            Schema::drop('deliveries');

        if(Schema::hasTable('reference_deliveries'))
            Schema::drop('reference_deliveries');

        if(Schema::hasTable('attachments'))
            Schema::drop('attachments');
    }
}
