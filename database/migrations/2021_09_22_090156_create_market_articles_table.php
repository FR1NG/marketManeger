<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id');
            $table->foreignId('market_category_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('unit');
            $table->unsignedInteger('quantity');
            $table->double('unit_price');
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
        Schema::dropIfExists('market_articles');
    }
}
