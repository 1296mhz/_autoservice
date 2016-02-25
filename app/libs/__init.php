<?php
error_reporting(E_ALL);

include_once(dirname(__FILE__) . "/__logs.php");
include_once(dirname(__FILE__) . "/__mysql.php");
include_once(dirname(__FILE__) . "/gump.class.php");

class Application
{
    public static function sendJsonString( $json )
    {
        header('Content-Type: application/json');
        echo $json;
        exit();
    }

    public static function sendJson( $data )
    {
        Application::sendJsonString( json_encode($data) );
    }

    public static function sendHTMLString( $html )
    {
        echo $html;
        exit();
    }

    public static function template( $file, $options )
    {
        ob_start();
        extract($options);
        include_once($file);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}




