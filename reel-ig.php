<?php
header('Content-Type: application/json');

$curl = curl_init();

$reel_url = 'https://www.instagram.com/reel/C2GTlaISSwT/';

curl_setopt_array($curl, array(
    CURLOPT_URL => "$reel_url?__a=1&__d=dis",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; Windows 11) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    ),
));

$response = curl_exec($curl);

curl_close($curl);

$jsonData = json_decode($response, true)['graphql']['shortcode_media'];

$reel_data = [
    'username'         => $jsonData['owner']['username'],
    'video_url'        => $jsonData['video_url'],
    'caption'          => $jsonData['edge_media_to_caption']['edges'][0]['node']['text'],
    'like'             => $jsonData['edge_media_preview_like']['count'],
    'video_view_count' => $jsonData['video_view_count'],
    'video_play_count' => $jsonData['video_play_count'],
];

echo json_encode($reel_data);
