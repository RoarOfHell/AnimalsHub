<?php
require_once 'vendor/connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idNews = mysqli_real_escape_string($connect, $_POST["newsId"]);
    $userId = mysqli_real_escape_string($connect, $_POST["userId"]);

    $checkNews = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count From LikedNews where IdUser = $userId and IdNews = $idNews;"))['count'];

    if($checkNews == 0){
        mysqli_query($connect, "insert into LikedNews (IdUser, IdNews) values ($userId, $idNews);");
        $countLikeNews = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count From LikedNews where IdNews = $idNews;"))['count'];
        echo json_encode([
            "status" => "add",
            "count" => $countLikeNews
        ], JSON_UNESCAPED_UNICODE);
    }
    else{
        mysqli_query($connect, "DELETE FROM LikedNews WHERE IdNews = $idNews and IdUser = $userId");
        $countLikeNews = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count From LikedNews where IdNews = $idNews;"))['count'];
        echo json_encode([
            "status" => "remove",
            "count" => $countLikeNews
        ], JSON_UNESCAPED_UNICODE);
    }   
}
else{
    echo "error";
}

?>