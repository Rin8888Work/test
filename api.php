<?php

$api_url = 'https://picsum.photos/v2/list?page=1&limit=9';

// Read JSON file
$json_data = file_get_contents($api_url);

// Decode JSON data into PHP array
$response_data = json_decode($json_data);

// Print data if need to debug
// echo "<pre>"; print_r($response_data);exit;

?>