<?php
include_once(dirname(__FILE__) . "/../models/index.php");

if( !$argv || count($argv) < 2 )
{
    print "Usage: add_repair_post.php [name]";
    exit(1);
}

print "add_repair_post: {$argv[1]}";

$newRepairPost = new RepairPost();
$newRepairPost->name = $argv[1];
$newRepairPost->save();

exit(0);