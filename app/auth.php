<?php
include_once '__mysql.php';

session_start();

function getUser()
{
    if( isset($_SESSION['authUser']) )
    {
        return $_SESSION['authUser'];
    }

    return null;
}

function authUser( $user )
{
    if( isset($_SESSION['authUser']) )
    {
        return false;
    }

    $_SESSION['authUser'] = $user;

    return true;
}

function exitUser()
{
   if( isset($_SESSION['authUser']) )
   {
        unset($_SESSION['authUser']);
        return true;
   }

   return true;
}

function setAuthHeaders()
{
    header('WWW-Authenticate: Basic realm="Хули хотел?"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Иди нахуй петушок';
    exit;
}

function checkAuth()
{
    if( getUser() == null )
    {
        setAuthHeaders();
    }
    else
    {

    }
}