<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpsellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upsells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->string("title", 255);
            $table->float("price");
            $table->string("image")->nullable();
            $table->text("description")->nullable();
            $table->boolean("is_active")->default(0);
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
        Schema::dropIfExists('upsells');
    }
}
