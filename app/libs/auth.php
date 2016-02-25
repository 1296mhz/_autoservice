<?php
include_once(dirname(__FILE__) . "/__logs.php");
include_once(dirname(__FILE__) . "/__mysql.php");
include_once(dirname(__FILE__) . "/../models/index.php");


session_start();

function getUser()
{
    if( isset($_SESSION['authUser']) )
    {
        return User::retrieveByPK( $_SESSION['authUser'] );
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
   toLog($_SERVER['PHP_AUTH_PW']);

   if( isset($_SERVER['PHP_AUTH_USER']) )
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

function redirect( $location )
{
    header('Location: ' . $location);
    exit;
}

function checkAuth()
{
    $user = getUser();

    if( $user == null )
    {
        if( !isset($_SERVER['PHP_AUTH_USER']) )
        {
            setAuthHeaders();
        }
        else
        {
            $name     = $_SERVER['PHP_AUTH_USER'];
            $password = md5($_SERVER['PHP_AUTH_PW']);

            $user = User::sql("SELECT * FROM :table WHERE name = '$name' AND password = '$password'", SimpleOrm::FETCH_ONE);

            if( $user )
            {
                unset($_SERVER['PHP_AUTH_PW']);
                authUser( $user->id );
            }
            else
            {
                setAuthHeaders();
            }
        }
    }

    return $user;
}