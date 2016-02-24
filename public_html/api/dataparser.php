<?php
include( dirname(__FILE__) . "/../../app/__init.php" );
include( dirname(__FILE__) . "/../../app/GreaseRatEvent.model.php" );
include( dirname(__FILE__) . "/../../app/auth.php" );

checkAuth();

function validateExists( $dst, $name )
{
    $values = array_keys( $dst );
    return in_array( $name, $values );
}

function validateEmpty( $dst, $name )
{
    return !empty($dst[$name]);
}

function validateInt( $dst, $name )
{
    return is_numeric($dst[$name]);
}

function validateDate( $dst, $name )
{
    if( !validateExists( $dst, $name ) )
    {
        return false;
    }

    return true;
}

function validateValue( $validateConfig, $validateFn, $post)
{
    $validateResult = [];

    foreach ($validateConfig[$validateFn] as $key => $value)
    {
        if( !call_user_func($validateFn, $post, $value))
        {
            array_push($validateResult, $value);
        }
    }

    if( count( $validateResult ) > 0 )
    {
        return showErrors($validateFn, $validateResult);
    }
}

function showErrors( $name, $data )
{
    sendJsonString(json_encode((Object)[
        "err" => $name,
        "data" => $data
    ]));
}

function validatePostData( $post )
{
    $valueNames = array(
        "repairPost",
        "customer",
        "typeOfRepair",
        "avtoModel",
        "gosNumber",
        "mileage",
        "gosNumber",
        "vin",
        "status",
        "startdatetime",
        "enddatetime"
    );

    $validateConfig = array(
        "validateExists" => array(
            "repairPost",
            "customer",
            "typeOfRepair",
            "avtoModel",
            "gosNumber",
            "mileage",
            "gosNumber",
            "status",
            "startdatetime",
            "enddatetime"
        ),
        "validateEmpty" => array(
            "customer",
            "mileage",
            "gosNumber",
            "startdatetime",
            "enddatetime"
        ),
        "validateDate" => array(
            "startdatetime",
            "enddatetime"
        ),
        "validateInt" => array(
            "repairPost",
            "typeOfRepair",
            "avtoModel",
            "status",
            "mileage",
        )
    );

    $filteredPost = [];
    foreach ($post as $key => $value)
    {
        if( in_array($key, $valueNames) )
        {
            $filteredPost[$key] = $value;
        }
    }

    validateValue($validateConfig, "validateExists", $filteredPost);
    validateValue($validateConfig, "validateEmpty", $filteredPost);
    validateValue($validateConfig, "validateInt", $filteredPost);
    validateValue($validateConfig, "validateDate", $filteredPost);

    $newEvent = new GreaseRatEvent;
    $newEvent->repairPost    = intval($filteredPost["repairPost"]);
    $newEvent->customer      = $filteredPost["customer"];
    $newEvent->typeOfRepair  = intval($filteredPost["typeOfRepair"]);
    $newEvent->avtoModel     = intval($filteredPost["avtoModel"]);
    $newEvent->mileage       = intval($filteredPost["mileage"]);
    $newEvent->gosNumber     = $filteredPost["gosNumber"];
    $newEvent->vin           = $filteredPost["vin"];
    $newEvent->status        = intval($filteredPost["status"]);
    $newEvent->state         = 0;
    $newEvent->startdatetime = $filteredPost["startdatetime"];
    $newEvent->enddatetime   = $filteredPost["enddatetime"];
    $newEvent->save();

    sendJsonString(json_encode($newEvent));
}

if( $_POST )
{
    validatePostData( $_POST );
}


