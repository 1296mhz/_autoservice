<?php
include_once(dirname(__FILE__) . "/../models/index.php");

if( !$argv || count($argv) < 3 )
{
    print "Usage: add_repair_type.php [repair_post_id] [name]";
    exit(1);
}

$newRepairType = new RepairType();
$newRepairType->repair_post = intval($argv[1]);
$newRepairType->name = $argv[2];
$newRepairType->save();

exit(0);