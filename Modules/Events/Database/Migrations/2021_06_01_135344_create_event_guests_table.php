<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_guests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('event_id')->unsigned();
            $table->string('fullname', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('ticket_name', 255)->nullable();
            $table->double('ticket_price', 13, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->text('info_items')->nullable();
            $table->string('status')->default('registered'); //('registered','joined')
            $table->timestamp('joined_at')->nullable(); // time checkin
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_guests');
    }
}
