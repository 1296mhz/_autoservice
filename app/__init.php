<?php
include_once '__mysql.php';
include_once '__logs.php';

function sendJsonString( $json )
{
    header('Content-Type: application/json');
    echo $json;
    exit();
}
