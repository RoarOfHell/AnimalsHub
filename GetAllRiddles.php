<?php
session_start();
    require_once 'connect.php';
    
    
   $result = mysqli_fetch_assoc(mysqli_query($connect, "select * from Riddles where Id = 1"));
  
   echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>