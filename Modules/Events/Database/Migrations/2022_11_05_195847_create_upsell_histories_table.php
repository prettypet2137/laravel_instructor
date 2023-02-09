<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpsellHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upsell_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("event_id")->unsigned();
            $table->bigInteger("guest_id")->unsigned();
            $table->bigInteger("upsell_id")->unsigned();
            $table->double("price")->default(0);
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
        Schema::dropIfExists('upsell_histories');
    }
}
