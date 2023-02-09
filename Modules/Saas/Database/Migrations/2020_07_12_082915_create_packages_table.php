<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Nwidart\Modules\Facades\Module;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 13, 2);
            $table->enum('interval', ['day', 'week', 'month', 'year'])->default('month');
            $table->integer('interval_number')->nullable();
            $table->longText('settings')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
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
        Schema::dropIfExists('packages');
    }
}
