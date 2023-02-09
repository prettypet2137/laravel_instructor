<?php

return [
    'name' => 'Events',
    'menu' => [
        'siderbar_position' => 3,
        'siderbar_admin_position' => 2,
        'header_top_left' => 1,
        'account_payment_position' => 2,
    ],
    'per_page' => 9,

    'currencies' => [
        "USD" => "$ | United States dollar",
        "EUR" => "£ | Euro",
        "JPY" => "¥ | Japanese yen",
        "GBP" => "£ | Pound sterling",
        "BRL" => "R$ | Brazilian real",
        "PLN" => "zł | Polish złoty",
    ],
    'EVENT_EMAIL_CONTENT' => '<p>Congratulations&nbsp; <strong>%guest_fullname%</strong> successfully registered for the event.</p>
                        <p><strong>%event_name%</strong> will be started on&nbsp;&nbsp;<strong><span>%event_start_date% </span><span>&nbsp;</span></strong></p>
                        <p><span>At the location:&nbsp;</span><strong><span>%event_address%</span></strong></p>
                        <hr />
                        <p><strong>This is your QR code for check in Event:</strong></p>
                        <p><span>%qr_code%</span></p>
                        <p><span style="color: #ba372a;">**How to use this QR code? Please print the code or do not delete this email until the day of the event. Present the printed or opened code on your smartphone when checking tickets</span></p>',
];