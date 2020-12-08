<?php
    require 'vendor/autoload.php';

    $session = new SpotifyWebAPI\Session(
                'bc918caade28414794cc1bfc8519ed20',
                '6f406d87d4834de1bc83b2f81e97cb96',
                'http://localhost:8888/SpotifyApp/songlist.php'
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
                echo '<a href="' . $playlist->external_urls->spotify . '">' . $playlist->name . ' ' . $playlist->id . '</a> <br>';
            }

        ?>
            <br/>
            <br/>

    <?php
            $playlistTracks = $api->getPlaylistTracks('6BFeszm9H2QvDCNe2g31at');

            foreach ($playlistTracks->items as $track) {
                $track = $track->track;
            
                echo '<a href="' . $track->external_urls->spotify . '">' . $track->name . '</a> <br>';
            }
    ?>

        <br/>
        <br/>

    <?php
            // It's now possible to request data about the currently authenticated user
            print_r($api->me()); 
        } else {
            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    ?>
</body>
</html>