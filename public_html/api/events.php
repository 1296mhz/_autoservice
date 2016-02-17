<?php
include( dirname(__FILE__) . "/../../app/__init.php" );
include( dirname(__FILE__) . "/../../app/GreaseRatEvent.model.php" );
include( dirname(__FILE__) . "/../../app/auth.php" );

$utc_fix = "-2 hours";

$startdatetime = date("Y-m-d H:i:s");
$enddatetime   = date("Y-m-d H:i:s");

if( isset($_GET["from"]) )
{
    $startdatetime = date('Y-m-d', intval($_GET["from"]) / 1000);
}

if( isset($_GET["to"]) )
{
    $enddatetime = date('Y-m-d', intval($_GET["to"]) / 1000);
}


$sql_prefix = "SELECT * FROM :table WHERE ";

function createBetween($name, $start, $end)
{
    return " " . $name . " BETWEEN '" . $start . "' AND '" . $end . "'";
}

/*
$sql = $sql_prefix .
       createBetween("startdatetime", $startdatetime, $startdatetime) .
       " AND " .
       createBetween("enddatetime", $enddatetime, $enddatetime);

toDebug( $sql );
*/

$sql = $sql_prefix . " DATE(startdatetime) >= '" . $startdatetime . "' AND DATE(enddatetime) <= '" . $enddatetime . "'";

$greaseRatEvents = GreaseRatEvent::sql($sql);

function decorateEventName( $event )
{
    return "Запись №: " . $event->id . " с " . $event->startdatetime . " по " . $event->enddatetime;
}

$eventsData = [];
foreach( $greaseRatEvents as $event )
{
    array_push($eventsData, array(
         'id' => $event->id,
         'title' => decorateEventName( $event ),
         'url' => 'www',
         'class' => 'event-important',
         'start' => strtotime($utc_fix, strtotime($event->startdatetime) ) . '000',
         'end' => strtotime($utc_fix, strtotime($event->enddatetime) ) . '000',
    ));
}

sendJsonString( json_encode(array('success' => 1, 'result' => $eventsData)) );
