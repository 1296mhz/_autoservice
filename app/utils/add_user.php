<?php
include_once(dirname(__FILE__) . "/../models/index.php");

if( !$argv || count($argv) < 4 )
{
    print "Usage: add_user.php [user_name] [role] [password]";
    exit(1);
}

$newUser = new User();
$newUser->name = $argv[1];
$newUser->role = $argv[2];
$newUser->password = md5($argv[3]);
$newUser->save();

exit(0);