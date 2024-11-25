<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newsId = mysqli_real_escape_string($connect, $_POST['newsId']);

    $comments = mysqli_fetch_all(mysqli_query($connect, "SELECT c.Id, c.Author, c.Comment, c.DateTime, u.UserId, u.UserName, u.Name, u.MiddleName, u.ImageUrl FROM `Comments` c
    LEFT JOIN UserDetails u on c.Author = u.UserId
    WHERE c.News = $newsId"));

    echo json_encode($comments, JSON_UNESCAPED_UNICODE);
}
else{
    echo "error";
}