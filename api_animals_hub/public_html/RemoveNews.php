<?php

require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newsId = mysqli_real_escape_string($connect, $_POST['newsId']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    mysqli_query($connect, "DELETE FROM News WHERE Id = $newsId and Author = $userId");
    echo "successfully";
}
else{
    echo "error";
}