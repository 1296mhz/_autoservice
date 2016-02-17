<?php
header('Content-Type: application/json');

include 'SimpleOrm.class.php';
include 'Logger.php';

$log = logger::getInstance();
$log->logfile = dirname(__FILE__) . '/../logs/app.log';

function appError( $message )
{
    global $log;
    $log->write( $message, __FILE__, __LINE__ );
    die();
}

function toLog( $message )
{
    global $log;
    $log->write( $message, __FILE__, __LINE__ );
}

function toDebug( $message )
{
    global $log;
    $log->write( $message, __FILE__, __LINE__ );
}


$conn = new mysqli('localhost', 'makkrisnru_serv', 'jkde#Jd48jJJE3');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

SimpleOrm::useConnection($conn, 'makkrisnru_serv');


