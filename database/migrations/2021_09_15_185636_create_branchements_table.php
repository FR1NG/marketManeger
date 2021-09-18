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
            $table->string('contract_number');
            $table->string('client_name');
            $table->string('address');
            $table->string('intervention');
            $table->string('estimate_number');
            $table->string('phone');
            $table->string('diameter')->nullable();
            $table->string('caliber');
            $table->string('nature');
            $table->date('arrival_date');
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