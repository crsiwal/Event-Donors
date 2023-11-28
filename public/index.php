<?php
session_start();
setlocale(LC_MONETARY, 'en_IN');
date_default_timezone_set('Asia/Kolkata');

/* Add the site translation text by language */
global $language;
$language = [];

// Set the Path of the root directory
define('BASEPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('LANG', 'hindi');

load("functions/eventReader");
load("language/" . LANG);

function base_url($path = "") {
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        "/" . $path
    );
}

function _t($langkey) {
    global $language;
    return isset($language[$langkey]) ? $language[$langkey] : "UNKNOWN KEY";
}

function load($filePath, $dataFile = "", $eventName = "") {
    require BASEPATH . $filePath . ".php";
}

$request = isset($_SERVER['REDIRECT_URL']) ? trim($_SERVER['REDIRECT_URL'], "/") : trim($_SERVER['REQUEST_URI'], "/");
$requestArr = explode("/", $request);

if (isset($requestArr[0]) && isset($requestArr[1])) {
    $filePath = BASEPATH . "events/" . $requestArr[0] . "-" . $requestArr[1] . ".php";
    if (file_exists($filePath)) {
        load("events/" . $requestArr[0] . "-" . $requestArr[1], $requestArr[0], $requestArr[1]);
    } else {
        load("donation", $requestArr[0], $requestArr[1]);
    }
} else {
    echo "Invalid request";
}
