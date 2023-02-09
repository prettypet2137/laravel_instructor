<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('purchase_code');
            $table->string('email_username_purchase');
            $table->string('version');
            $table->string('verify_type')->nullable();
            $table->string('path_main')->nullable();
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
        Schema::dropIfExists('purchase_managers');
    }
}
