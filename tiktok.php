<?php
header('Content-Type: application/json');

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://www.tiktok.com/@pomeglowofficial/video/7098964216316546331',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Cookie: tt_chain_token=+O8Mw9RH4nKrX/ACdOBhXw==; tt_csrf_token=27TtpaB8-Wftkj0rFR_w6LdtcAp4tdDCFfBY; ttwid=1%7CdJI7LAdiTNKwSISqHad9wDTJ6G_70WU_PGro2isx-ac%7C1705385087%7C518efef116162148489d7f25fa3c7b06633a23c824590f04ea0226d5c2b6f092'
	),
));

$response = curl_exec($curl);

curl_close($curl);

$html = "$response";

// Mencari script tag dengan ID __UNIVERSAL_DATA_FOR_REHYDRATION__
$pattern = '/<script id="__UNIVERSAL_DATA_FOR_REHYDRATION__" type="application\/json">(.*?)<\/script>/s';
preg_match($pattern, $html, $matches);

if (isset($matches[1])) {
    $jsonContent = $matches[1];

    $jsonData = json_decode($jsonContent, true)['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct'];

	$reel_data = [
		'username'         => $jsonData['author']['uniqueId'],
    	'video_url'        => $jsonData['video']['playAddr'],
		'caption'		   => $jsonData['desc'],
		'like' 			   => $jsonData['stats']['diggCount'],
		'video_play_count' => $jsonData['stats']['playCount'],
	];

	echo json_encode($reel_data);

} else {
    echo "Script tag dengan ID __UNIVERSAL_DATA_FOR_REHYDRATION__ tidak ditemukan.";
}
