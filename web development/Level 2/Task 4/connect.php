<?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db="todo";
  $conn = new mysqli($servername, $username, $password,$db);
  if(!$conn)
  {
    die ("Sorry for the inconvience");
  }
?>
