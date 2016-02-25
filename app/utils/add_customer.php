<?php
include_once(dirname(__FILE__) . "/../models/index.php");

if( !$argv || count($argv) < 2 )
{
    print "Usage: add_customer.php [customer_name] [customer_phone]";
    exit(1);
}

$newCustomer = new Customer();
$newCustomer->name = $argv[1];

if( count($argv) == 3 )
{
    $newCustomer->phone = $argv[2];
}

$newCustomer->save();

exit(0);