<?php
header('Content-Type: application/json');

include 'SimpleOrm.class.php';

$conn = new mysqli('127.0.0.1', 'grease_rat', 'grease_rat');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));


SimpleOrm::useConnection($conn, 'grease_rat');