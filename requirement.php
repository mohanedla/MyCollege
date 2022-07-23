<?php

$admin = 1;
require_once 'dbconn.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) {
    echo "<p>Error: Could not connect to database.<br/>
    Please try again later.</p>";
      die($conn -> error);
  }



  
?>