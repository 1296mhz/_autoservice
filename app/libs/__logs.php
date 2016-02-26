<?php
include_once(dirname(__FILE__) . "/Logger.php");

$log = logger::getInstance();
$log->logfile = dirname(__FILE__) . '/logs/app.log';

class Log
{
    public static function toLog($message, $file = __FILE__, $line = __LINE__)
    {
        global $log;
        $log->write( $message, __FILE__, __LINE__ );
    }

    /**
     * Записать в лог
     *
     * @param $message
     * @param string $file
     * @param int $line
     */
    public static function toDebug($message, $file = __FILE__, $line = __LINE__)
    {
        global $log;

        $messageString = $message;

        if( is_array($message) )
        {
            $messageString = '';

            $messagesCount = count($message);

            for ($iArg = 0; $iArg < $messagesCount; $iArg++)
            {
                $messageString .= $message[$iArg] . " ";
            }
        }

        $log->write( $messageString, $file, $line );
    }


}



