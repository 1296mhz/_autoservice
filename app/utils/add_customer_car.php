<?php
include_once(dirname(__FILE__) . "/../models/index.php");

if( !$argv || count($argv) < 5 )
{
    print "Usage: add_customer_car.php [name] [mileage] [vin] [gv_number]";
    exit(1);
}

$newCustomerCar = new CustomerCar();
$newCustomerCar->name = $argv[1];
$newCustomerCar->mileage = $argv[2];
$newCustomerCar->vin = $argv[3];
$newCustomerCar->gv_number = $argv[4];
$newCustomerCar->save();

exit(0);