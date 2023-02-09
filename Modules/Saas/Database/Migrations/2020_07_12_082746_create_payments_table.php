<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id')->index();
            $table->integer('package_id');
            $table->string('reference')->nullable();
            $table->string('gateway');
            $table->double('total', 13, 2);
            $table->boolean('is_paid')->default(false);
            $table->longText('options')->nullable();
            $table->string('currency', 3);

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
        Schema::dropIfExists('payments');
    }
}
