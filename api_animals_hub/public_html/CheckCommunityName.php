<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $communityId = mysqli_real_escape_string($connect, $_POST['communityId']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE Community = $communityId and UserId = $userId"))['count'];

    
}
else{
    echo "error";
}