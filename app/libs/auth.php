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

function setAuthUser( $user )
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
    if( !isset($_SESSION['authUser']) )
    {
        return false;
    }

    unset($_SESSION['authUser']);

    return true;
}

function redirect( $location )
{
    header('Location: ' . $location);
    exit;
}

function redirectToLogin()
{
    redirect('/sign');
    exit;
}

function authUser($name, $password)
{
    $password = md5($password);
    $user = User::sql("SELECT * FROM :table WHERE name = '$name' AND password = '$password'", SimpleOrm::FETCH_ONE);

    if( $user )
    {
        setAuthUser( $user->id );
        return true;
    }

    return false;
}

function checkAuth()
{
    $user = getUser();

    if( $user )
    {
        return $user;
    }

    redirectToLogin();
}