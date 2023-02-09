<?php

namespace Modules\Email\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Email\Entities\EmailReminderTypes;

class EmailReminderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailReminderTypes::insert([
            ["type" => "Order Completed"],
            ["type" => "Payment Not Completed"],
            ["type" => "Course Rescheduled"],
            ["type" => "Birthday Greeting"],
            ["type" => "Event Reminder Day Before"],
            ["type" => "Event Reminder Day Of"],
            ["type" => "Event Cancelled"],
            ["type" => "Event Rescheduled"],
            ["type" => "Follow Up After Course"]
        ]);
    }
}
