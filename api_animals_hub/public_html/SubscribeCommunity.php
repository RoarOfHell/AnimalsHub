<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $communityId = mysqli_real_escape_string($connect, $_POST['communityId']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE Community = $communityId and UserId = $userId"))['count'];

    if($countSubs > 0){
        mysqli_query($connect, "delete from SubscribersCommunity where Community = $communityId and UserId = $userId");

        $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE Community = $communityId"))['count'];

        echo json_encode([
            "status" => "removed",
            "count" => $countSubs
        ], JSON_UNESCAPED_UNICODE);
    }
    else{
        mysqli_query($connect, "insert into SubscribersCommunity (Community, UserId) values ($communityId, $userId);");

        $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE Community = $communityId"))['count'];

        echo json_encode([
            "status" => "added",
            "count" => $countSubs
        ], JSON_UNESCAPED_UNICODE);
    }
}
else{
    echo "error";
}