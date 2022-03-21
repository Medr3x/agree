<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('sku_id', 25)->index();
            $table->boolean('first_edition')->default(0);
            $table->string('serial_code',50);
            $table->unsignedInteger('category_id')->index();
            $table->integer('atk')->nullable();
            $table->integer('def')->nullable();
            $table->integer('qty_star')->nullable();
            $table->string('description');
            $table->float('price',12,2);
            $table->string('image')->nullable();
            $table->timestamp('card_creation_date');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('users_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->unsignedInteger('card_id')->nullable()->index();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->softDeletes();
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
        Schema::dropIfExists('cards');
        Schema::dropIfExists('users_cards');
    }
}
