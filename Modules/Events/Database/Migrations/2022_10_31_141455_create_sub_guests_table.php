<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('guest_id')->unsinged();
            $table->string("fullname");
            $table->string("email");
            $table->text("info_items")->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->foreign('guest_id')->references('id')->on('event_guests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_guests');
    }
}
