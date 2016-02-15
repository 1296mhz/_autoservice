<?php
//$start = date('Y-m-d h:i:s', ($_GET['start'] / 1000));
//echo $start;


$out = array();

 for($i=1; $i<=15; $i++){   //from day 01 to day 15
     $data = date('Y-m-d', strtotime("+".$i." days"));
     $out[] = array(
         'id' => $i,
         'title' => 'Событие номер: '.$i,
         'url' => 'www',
         'class' => 'event-important',
         'start' => strtotime($data).'000',
          'end' => strtotime($data).'030'
     );
 }
var_dump($data);
//echo json_encode(array('success' => 1, 'result' => $out));
exit;
?>
