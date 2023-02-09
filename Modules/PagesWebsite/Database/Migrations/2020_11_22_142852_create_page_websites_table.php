<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_websites', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title');
            $table->longText('description');
            $table->string('slug')->unique();
            $table->boolean('is_active')->index();
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
        Schema::dropIfExists('page_websites');
    }
}
