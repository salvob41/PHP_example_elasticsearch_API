<?php
ini_set('display_errors', 1);
require_once __DIR__ . "/include/configuration.php";

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

$params = [
    "scroll" => "30s",          // how long between scroll requests. should be small!
    "size" => 50,               // how many results *per shard* you want back
    "index" => INDEX_NAME,
    "body" => [
        "query" => [
            "match_all" => new stdClass()
        ]
    ]
];

// Execute the search
// The response will contain the first batch of documents
// and a scroll_id
$response = $client->search($params);
$complete_response = [];
// Now we loop until the scroll "cursors" are exhausted
while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {

    // **
    // Do your work here, on the $response['hits']['hits'] array
    // **

    // When done, get the new scroll_id
    // You must always refresh your _scroll_id!  It can change sometimes
    $scroll_id = $response['_scroll_id'];

    $complete_response = array_merge($complete_response, $response['hits']['hits']);

    // Execute a Scroll request and repeat
    $response = $client->scroll([
            "scroll_id" => $scroll_id,  //...using our previously obtained _scroll_id
            "scroll" => "30s"           // and the same timeout window
        ]
    );


}
print_r(json_encode($complete_response, JSON_PRETTY_PRINT));
