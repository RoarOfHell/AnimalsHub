<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $author and Subscriber = $userId"))['count'];

    if($countSubs > 0){
        mysqli_query($connect, "delete from Subscribers where Subscriber = $userId and Author = $author");

        $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $author"))['count'];

        echo json_encode([
            "status" => "removed",
            "count" => $countSubs
        ], JSON_UNESCAPED_UNICODE);
    }
    else{
        mysqli_query($connect, "insert into Subscribers (Author, Subscriber) values ($author, $userId);");

        $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $author"))['count'];

        echo json_encode([
            "status" => "added",
            "count" => $countSubs
        ], JSON_UNESCAPED_UNICODE);
    }
}
else{
    echo "error";
}