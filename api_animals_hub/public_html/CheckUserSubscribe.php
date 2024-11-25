<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    echo mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $author and Subscriber = $userId"))['count'] > 0 ? "yes" : "no";
}
else{
    echo "error";
}