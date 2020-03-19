<?php

use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

$client = new Client();

date_default_timezone_set('Asia/Taipei');

$get_ticket_date = date("Y/m/d", mktime(0, 0, 0, date("m"), date("d") + 8, date("Y")));

$can_start_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
$end_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 10, date("m"), date("d") + 1, date("Y")));
$now = date("Y-m-d H:i:s", strtotime('now'));

$is_can_get_ticket = true;


while ($is_can_get_ticket) {
    if ($now > $can_start_get_ticket_time) {
        $this.postTicket($get_ticket_date);
    }

    if ($now > $$end_get_ticket_time) {
        $is_can_get_ticket = false;
    }
}

function postTicket($get_ticket_date)
{
    $jar = \GuzzleHttp\Cookie\CookieJar::fromArray(
        [
            'ASP.NET_SessionId' => 'oqafhhcax1g2xgtx4taugici',
        ],
        'scr.cyc.org.tw'
    );

    $query = [
        'module' => 'net_booking',
        'files' => 'booking_place',
        'StepFlag' => 25,
        'QPid' => 84,
        'QTime' => 6,
        'D' => $get_ticket_date,
    ];

    $client->request('GET', 'https://scr.cyc.org.tw/tp12.aspx', [
        'query' => $query,
        'cookies' => $jar,
    ]);

}