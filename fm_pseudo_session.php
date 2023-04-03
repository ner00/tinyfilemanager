<?php
// Prevent direct access
if (stristr($_SERVER["REQUEST_URI"], basename(__FILE__))
|| basename($_SERVER['PHP_SELF']) == basename(__FILE__)) 
{
	four_o_four_error();
}

// private key and session name to store to the session
if (!defined('FM_SESSION_ID')) {
    define('FM_SESSION_ID', 'filemanager');
}

session_cache_limiter('nocache');
session_name(FM_SESSION_ID);
session_start();

if (!isset($_SESSION[FM_SESSION_ID]['logged']) || $_SESSION[FM_SESSION_ID]['logged'] == '') {
	four_o_four_error();
}

function four_o_four_error() {
    // Simulate authentic 404 error page
    $options = [
        'http' => [
            'ignore_errors' => true,
            'header' => "Content-Type: application/json\r\n",
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ],
    ];
    $random_url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.bin2hex(random_bytes(16)).'.404';
    http_response_code(404);
    if($result = @file_get_contents($random_url, false, stream_context_create($options))) {
        die($result);
    } else {
        exit;
    }
}
?>
