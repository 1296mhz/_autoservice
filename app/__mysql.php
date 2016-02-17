<?php
include_once 'SimpleOrm.class.php';

$conn = new mysqli('localhost', 'grease_rat', 'grease_rat');

if ($conn->connect_error)
  die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

SimpleOrm::useConnection($conn, 'grease_rat');