<?php
    require 'vendor/autoload.php';

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

    $api = new SpotifyWebAPI\SpotifyWebAPI();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

            $playlists = $api->getUserPlaylists($api->me()->id, [
                'limit' => 5
            ]);
            
            foreach ($playlists->items as $playlist) {
                echo '<a href="' . $playlist->external_urls->spotify . '">' . $playlist->name . '</a> <br>';
            }

            // It's now possible to request data about the currently authenticated user
            print_r($api->me()); ?>
            <br/>
            <br/>

            <?php
            // Getting Spotify catalog data is of course also possible
            print_r(
                $api->getTrack('7EjyzZcbLxW7PaaLua9Ksb')
            );
        } else {
            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    ?>
</body>
</html>