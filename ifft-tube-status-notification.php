#!/usr/bin/php

<?php

$key_input = file_get_contents('php://input');
$key_ini = parse_ini_file('key.ini');
$key = $key_ini['key'];
if($key !== $key_input) {
    http_response_code(404);
    die();
}

$lines = ["central", "jubilee", "london-overground"];

$lines_argument = array_reduce($lines, function ($carry, $item) {
    return $carry . $item . ",";
});

$json_response = file_get_contents("https://api.tfl.gov.uk/Line/$lines_argument/Status?detail=false");

$tube_status = json_decode($json_response);

$response = "";
foreach ($tube_status as $line) {
    $name = $line->name;
    $status = $line->lineStatuses[0]->statusSeverityDescription;
    if(property_exists($line->lineStatuses[0], 'reason')) {
        $response .= $line->lineStatuses[0]->reason . "\n";
    } else {
        $response .= "$name: $status\n";
    }
}

echo $response . "\n";

$data = json_encode(array("value1" => $response));

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => $data
    )
);
$context  = stream_context_create($options);
$url = "https://maker.ifttt.com/trigger/tube_notify/with/key/vMdF3AjkPPzNrkudui8VX";
echo file_get_contents($url, false, $context);