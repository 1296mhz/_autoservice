<?php

include 'SimpleOrm.class.php';

$conn = new mysqli('127.0.0.1', 'grease_rat', 'grease_rat');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

//echo var_dump($_POST);

SimpleOrm::useConnection($conn, 'grease_rat');


/**
-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `grease_rat_work`;
CREATE TABLE `grease_rat_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repairPost` int(11) NOT NULL,
  `customer` text COLLATE utf8_unicode_ci NOT NULL,
  `typeOfRepair` int(11) NOT NULL,
  `avtoModel` tinyint(4) NOT NULL,
  `mileage` int(11) NOT NULL,
  `vin` text COLLATE utf8_unicode_ci NOT NULL,
  `startdatetime` datetime NOT NULL,
  `enddaetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-02-15 17:06:28
*/
class GreaseRatEvent extends SimpleOrm
{
    protected static
      $table = 'grease_rat_work';
}

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
    return is_int($dst[$name]);
}

function validateDate( $dst, $name )
{
    if( validateExist( $dst, $name ) )
    {
        return false;
    }

    return true;
//  return is_int($dst[$name]);
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
    echo json_encode((Object)[
        "err" => $name,
        "data" => $data
    ]);
    die();
}

function validatePostData( $post )
{
    // var_dump( $post );

    // $post["repairPost"]
    // $post["customer"]
    // $post["typeOfRepair"]
    // $post["avtoModel"]
    // $post["mileage"]
    // $post["vin"]
    // $post["startdatetime"]
    // $post["enddaetime"]

    $valueNames = array(
        "repairPost",
        "customer",
        "typeOfRepair",
        "avtoModel",
        "mileage",
        "vin",
        "startdatetime",
        "enddaetime"
    );

    $validateConfig = array(
        "validateExists" => array(
            "repairPost",
            "customer",
            "typeOfRepair",
            "avtoModel",
            "mileage",
            "startdatetime",
            "enddaetime"
        ),
        "validateEmpty" => array(
            "customer",
            "mileage",
            "startdatetime",
            "enddaetime"
        ),
        "validateDate" => array(
            "startdatetime",
            "enddaetime"
        ),
        "validateInt" => array(
            "repairPost",
            "typeOfRepair",
            "avtoModel",
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

    var_dump($filteredPost);


    $newEvent = new GreaseRatEvent;
    $newEvent->repairPost    = $filteredPost["repairPost"];
    $newEvent->customer      = $filteredPost["customer"];
    $newEvent->typeOfRepair  = $filteredPost["typeOfRepair"];
    $newEvent->avtoModel     = $filteredPost["avtoModel"];
    $newEvent->mileage       = $filteredPost["mileage"];
    $newEvent->vin           = $filteredPost["vin"];
    $newEvent->startdatetime = $filteredPost["startdatetime"];
    $newEvent->enddaetime    = $filteredPost["enddaetime"];
    $newEvent->save();

    echo json_encode((Object)[]);

    die();
}


if( $_POST )
{
    validatePostData( $_POST );
}



