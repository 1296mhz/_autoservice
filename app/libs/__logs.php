<?php
include_once(dirname(__FILE__) . "/Logger.php");

$log = logger::getInstance();
$log->logfile = dirname(__FILE__) . '/logs/app.log';

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