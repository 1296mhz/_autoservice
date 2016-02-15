<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 14.02.16
 * Time: 16:55
 */
include "../../class/router.php";
$Router = new Router;
$cfg = $Router->getConfig('../../config/config.json');



if(isset($_GET['index']) &&  strlen($_GET['index'])>0){
      $Router->index($_GET['index']);
}

