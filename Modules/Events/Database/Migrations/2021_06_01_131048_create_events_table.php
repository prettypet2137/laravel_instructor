<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('user_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->text('tagline')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('register_end_date')->nullable();

            $table->string('type', 255)->nullable(); // ONLINE, OFFLINE
            $table->string('address', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('email_content')->nullable();
            $table->string('second_email_subject')->nullable();
            $table->text('second_email_content')->nullable();
            $table->boolean('second_email_status')->default(1);
            $table->string('second_email_attach')->nullable();
            $table->text('noti_register_success')->nullable();
            $table->string('short_slug', 255)->nullable();
            $table->text('info_items')->nullable();
            $table->text('ticket_items')->nullable();
            $table->text('upsells')->nullable();
            
            // setting
            $table->string('favicon', 255)->nullable();
            $table->string('custom_domain', 255)->nullable();
            
            // search SEO
            $table->boolean('seo_enable')->default(true);
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            // social seo
            $table->text('social_title')->nullable();
            $table->string('social_image', 255)->nullable();
            $table->text('social_description')->nullable();
            // customize theme
            $table->string('theme', 255)->default('default');
            $table->string('theme_color', 255)->nullable();
            $table->string('background', 255)->nullable();
            $table->string('font_family', 255)->nullable();
            $table->text('custom_header')->nullable(); //css or libray
            $table->text('custom_footer')->nullable(); //css or libray
            $table->boolean("is_recur")->default(0);
            $table->text('terms_and_conditions')->nullable();
            $table->unsignedBigInteger("event_id")->nullable();
            $table->foreign("event_id")->references("id")->on("users");

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
        Schema::dropIfExists('events');
    }
}
