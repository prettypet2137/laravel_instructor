<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('comment_users', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        //     $table->string('name');
        //     $table->text('description');
        //     $table->string('email');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_users');
    }
}
