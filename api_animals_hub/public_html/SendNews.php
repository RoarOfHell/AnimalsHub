<?php
require_once 'vendor/connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $messageNews = mysqli_real_escape_string($connect, $_POST["message"]);
    $userId = mysqli_real_escape_string($connect, $_POST["userId"]);
    $isCommunity = mysqli_real_escape_string($connect, $_POST["isCommunity"]);
    $communityId = mysqli_real_escape_string($connect, $_POST["communityId"]);

    mysqli_query($connect, "insert into News (Text, Author, CommunityId, DateTime, IsCommunity) values ('$messageNews', $userId, $communityId, NOW(), $isCommunity)");
    $id = $connect->insert_id;
    echo json_encode([
        "id" => $id,
        "result" => "successfully"
    ], JSON_UNESCAPED_UNICODE);
}
else{
    echo json_encode([
        "id" => 0,
        "result" => "error"
    ], JSON_UNESCAPED_UNICODE);
}

?>