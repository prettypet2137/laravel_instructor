<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('twilio_sid');
            $table->string('twilio_token');
            $table->string('twilio_number');
            $table->double("sms_fee")->default(2);
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
        Schema::dropIfExists('sms_accounts');
    }
}
