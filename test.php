<?php

use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

$client = new Client();

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
    'D' => '2020/03/26',
];

$client->request('GET', 'https://scr.cyc.org.tw/tp12.aspx', [
    'query' => $query,
    'cookies' => $jar
]);

