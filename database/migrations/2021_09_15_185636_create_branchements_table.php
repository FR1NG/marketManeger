<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id');
            $table->foreignId('market_article_id');
            $table->foreignId('city_id');
            $table->string('type');
            $table->string('contract_number');
            $table->string('client_name');
            $table->string('address');
            $table->string('intervention')->nullable();
            $table->string('estimate_number');
            $table->string('phone');
            $table->string('diameter')->nullable();
            $table->string('caliber')->nullable();
            $table->string('nature')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('motive')->nullable();
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
        Schema::dropIfExists('branchements');
    }
}
