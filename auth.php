<?php

require_once 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    'bc918caade28414794cc1bfc8519ed20',
    '6f406d87d4834de1bc83b2f81e97cb96',
    'http://localhost:8888/SpotifyApp/'
);

$options = [
    'scope' => [
        'playlist-read-private',
        'user-read-private',
    ],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();