<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracklinks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('target_class', 191)->nullable();
            $table->bigInteger('target_id')->nullable();
            $table->string('country_code', 191)->nullable();
            $table->string('city_name', 191)->nullable();
            $table->string('os_name', 191)->nullable();
            $table->string('browser_name', 191)->nullable();
            $table->string('referrer_host', 191)->nullable();
            $table->string('referrer_path', 1024)->nullable();
            $table->string('device_type', 191)->nullable();
            $table->string('browser_language', 191)->nullable();
            $table->string('utm_source', 191)->nullable();
            $table->string('utm_medium', 191)->nullable();
            $table->string('utm_campaign', 191)->nullable();
            $table->boolean('is_unique')->nullable()->default(0);
            $table->timestamp('datetime')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracklinks');
    }
}
