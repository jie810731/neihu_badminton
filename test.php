<?php

use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

if (isset($argv[1])) {
    $session = $argv[1];
}

if (!$session) {
    echo ('empty session');
    return;
}
//24小時
$times = [19, 20, 21];

$client = new Client();

date_default_timezone_set('Asia/Taipei');

$get_ticket_date = date("Y/m/d", mktime(0, 0, 0, date("m"), date("d") + 8, date("Y")));

$can_start_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
$end_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 10, date("m"), date("d") + 1, date("Y")));
$now = date("Y-m-d H:i:s", strtotime('now'));

$is_can_get_ticket = true;

echo ('going to start loop');
while ($is_can_get_ticket) {
    if ($now > $can_start_get_ticket_time) {
        echo ('post');
        foreach ($times as $time) {
            $this . postTicket($get_ticket_date, $time);
        }
    }

    if ($now > $end_get_ticket_time) {
        echo ('over time');
        $is_can_get_ticket = false;
    }
}
echo ('loop end');

function postTicket($get_ticket_date, $order_time)
{
    if (!$get_ticket_date || !$order_time) {
        return;
    }

    $jar = \GuzzleHttp\Cookie\CookieJar::fromArray(
        [
            'ASP.NET_SessionId' => $session,
        ],
        'scr.cyc.org.tw'
    );

    $query = [
        'module' => 'net_booking',
        'files' => 'booking_place',
        'StepFlag' => 25,
        'QPid' => 84,
        'QTime' => $order_time,
        'D' => $get_ticket_date,
    ];

    $client->request('GET', 'https://scr.cyc.org.tw/tp12.aspx', [
        'query' => $query,
        'cookies' => $jar,
    ]);

}