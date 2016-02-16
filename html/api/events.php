<?php
include( dirname(__FILE__) . "/../../app/__init.php" );
include( dirname(__FILE__) . "/../../app/GreaseRatEvent.model.php" );

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

$sql = $sql_prefix .
       createBetween("startdatetime", $startdatetime, $enddatetime) .
       " AND " .
       createBetween("enddatetime", $startdatetime, $enddatetime);

$greaseRatEvents = GreaseRatEvent::sql($sql);

$eventsData = [];
foreach( $greaseRatEvents as $event )
{
    array_push($eventsData, array(
         'id' => $event->id,
         'title' => 'Событие номер: '. $event->id,
         'url' => 'www',
         'class' => 'event-important',
         'start' => strtotime($event->startdatetime) . '000',
         'end' => strtotime($event->enddatetime) . '000',
    ));
}

echo json_encode(array('success' => 1, 'result' => $eventsData));
