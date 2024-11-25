<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newsId = mysqli_real_escape_string($connect, $_POST['news_id']);
    $userId = mysqli_real_escape_string($connect, $_POST['user_id']);
    $comment = mysqli_real_escape_string($connect, $_POST['comment']);

    mysqli_query($connect, "insert into Comments(Author, News, Comment, DateTime) values ($userId, $newsId, '$comment', NOW())");
    return "ok";
}
else{
    echo "error";
}