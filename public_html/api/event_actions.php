<?php
include( dirname(__FILE__) . "/../../app/__init.php" );
include( dirname(__FILE__) . "/../../app/GreaseRatEvent.model.php" );
include( dirname(__FILE__) . "/../../app/auth.php" );

checkAuth();

toLog(print_r($_POST, true));

if( !isset($_POST['action']) )
{
    return appError("UNDEFINED_ACTION");
}

$action = $_POST['action'];

function findEvent( $eventId )
{
    return GreaseRatEvent::sql("SELECT * FROM :table WHERE id = '$eventId'", SimpleOrm::FETCH_ONE);
}

switch($action)
{
    case "DELETE":
    {
        if( !isset($_POST['id']) )
        {
            return appError("UNDEFINED_EVENT_ID");
        }

        $event = findEvent( intval($_POST['id']) );

        if( !$event )
        {
            return appError("UNDEFINED_EVENT");
        }

        $event->delete();
        break;
    }

    case "MOVE":
    {
        if( !isset($_POST['id']) )
        {
            return appError("UNDEFINED_EVENT_ID");
        }
        if( !isset($_POST['startdatetime']) )
        {
            return appError("UNDEFINED_START_TIME");
        }
        if( !isset($_POST['enddatetime']) )
        {
            return appError("UNDEFINED_END_TIME");
        }

        $event = findEvent( intval($_POST['id']) );

        if( !$event )
        {
            return appError("UNDEFINED_EVENT");
        }

        $event->startdatetime = $_POST["startdatetime"];
        $event->enddatetime   = $_POST["enddatetime"];
        $event->save();

        break;
    }
    default:
    {
        return appError("UNDEFINED_ACTION");
    }
}

echo "OK";
exit();