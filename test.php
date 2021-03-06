<?php

use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

if (isset($argv[1])) {
    $session = $argv[1];
}
//dy2pbaomsvfy4h53nxneyid0
if (!$session) {
    echo ('empty session');
    return;
}
//24小時
$times = [20, 21];

$sections = [88, 87];

date_default_timezone_set('Asia/Taipei');

$get_ticket_date = date("Y/m/d", mktime(0, 0, 0, date("m"), date("d") + 8, date("Y")));
//$get_ticket_date = '2020/04/02';
$can_start_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") + 1 , date("Y")));

$end_get_ticket_time = date("Y-m-d H:i:s", mktime(0, 0, 10, date("m"), date("d") + 1, date("Y")));

$is_can_get_ticket = true;

echo ('going to start loop' . PHP_EOL);

while ($is_can_get_ticket) {
    $now = date("Y-m-d H:i:s", strtotime('now'));

    if ($now >= $can_start_get_ticket_time) {
        error_log($get_ticket_date. PHP_EOL, 3, "log.txt");

        foreach ($sections as $section) {
            foreach ($times as $time) {
                echo ("post time = {$time} " . PHP_EOL);

                postTicket($session, $get_ticket_date, $time, $section);

                echo ("post time = {$time} end " . PHP_EOL);
            }
        }

    } else {
        echo ("time  not yet now = {$now}" . PHP_EOL);
    }

    if ($now > $end_get_ticket_time) {
        echo ('over time' . PHP_EOL);
        $is_can_get_ticket = false;
    } else {
        echo ("continue loop" . PHP_EOL);
    }

}
echo ('loop end' . PHP_EOL);

function postTicket($session, $get_ticket_date, $order_time, $section)
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
        'QPid' => $section,
        'QTime' => $order_time,
        'D' => $get_ticket_date,
    ];

    $client = new Client();

    $client->request('GET', 'https://scr.cyc.org.tw/tp12.aspx', [
        'query' => $query,
        'cookies' => $jar,
    ]);

}
