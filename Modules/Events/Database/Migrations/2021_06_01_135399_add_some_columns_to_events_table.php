<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('email_subject')->nullable()->after('email_content');
            $table->string('email_sender_name')->nullable()->after('email_content');
            $table->string('email_sender_email')->nullable()->after('email_content');
            $table->string('ticket_currency')->nullable()->after('ticket_items');
            $table->timestamp('start_date')->nullable()->after('register_end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('events', ['ticket_currency','email_subject','email_sender_name','email_sender_email','start_date']);
    }
}
