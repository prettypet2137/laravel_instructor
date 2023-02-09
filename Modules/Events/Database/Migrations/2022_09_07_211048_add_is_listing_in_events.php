<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsListingInEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('events', function (Blueprint $table) {
        //     $table->boolean('is_listing')->default(true)->after('ticket_currency');
        //     $table->timestamp('end_date')->nullable()->after('start_date');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['is_listing','end_date']);
        });
    }
}
