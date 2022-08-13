<?php

$conn = new mysqli('localhost','root','','mycollege');
if ($conn->connect_error) {
    echo "<p>Error: Could not connect to database.<br/>
    Please try again later.</p>";
      die($conn -> error);
  }
?>