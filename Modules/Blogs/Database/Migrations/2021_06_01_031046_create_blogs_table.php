<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('slug');
            $table->text('content_short');
            $table->text('content');
            $table->string('thumb', 290)->nullable();
            $table->text('title_seo');
            $table->text('description_seo');
            $table->text('keyword_seo');
            $table->string('time_read');
            $table->integer('category_id');
            $table->integer('facebook_share')->default(0);
            $table->integer('linkedin_share')->default(0);
            $table->integer('twitter_share')->default(0);
            $table->integer('mail_share')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('blogs');
    }
}
