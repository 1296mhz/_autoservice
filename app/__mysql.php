<?php
include_once 'SimpleOrm.class.php';

$conn = new mysqli('localhost', 'makkrisnru_serv', 'jkde#Jd48jJJE3');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

SimpleOrm::useConnection($conn, 'makkrisnru_serv');