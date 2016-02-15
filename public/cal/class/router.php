<?php

/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 07.02.16
 * Time: 12:45
 */
class Router
{
    function getConfig($configfile)
    {
        $CONFIGFILE = file_get_contents($configfile);
        return json_decode($CONFIGFILE);
    }

    function index($method)
    {
        echo "Welcome to Calendar\n";

            switch ($method) {
                case 'createEvent':



                    echo "Create event!";
                    break;

                case 'removeEvent':
                    /*
                     $fh = fopen('/var/spool/nodenix/json/cpu.json', 'r');
                     $data = fread($fh, filesize('/var/spool/nodenix/json/cpu.json'));
                     echo $data;
                     fclose($fh);
                     */
                    echo "Remove event!";
                    break;
                case 'error':
                    /*
                     $fh = fopen('/var/spool/nodenix/json/cpu.json', 'r');
                     $data = fread($fh, filesize('/var/spool/nodenix/json/cpu.json'));
                     echo $data;
                     fclose($fh);
                     */
                    echo "error event!";
                    break;

            }


    }


}

