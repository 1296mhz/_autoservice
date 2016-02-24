<?php
include( dirname(__FILE__) . "/../../app/__init.php" );
include( dirname(__FILE__) . "/../../app/auth.php" );

if( exitUser() )
{
    setAuthHeaders();
}