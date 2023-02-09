<?php

namespace Modules\Sms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Sms\Entities\SmsReminderTypes;

class SmsReminderTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsReminderTypes::insert([
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
