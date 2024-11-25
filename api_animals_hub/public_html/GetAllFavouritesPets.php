<?php
    require_once 'vendor/connect.php';

    $user_id = mysqli_real_escape_string($connect, $_POST['userid']);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $query = "SELECT p.Id, ad.Name as AdTypeName, p.petNickname, p.imageUrl, p.petDescription, p.petPrice, p.Age, p.Breed, p.Veterinarian, p.petType, u.Id as UserId, u.Login, u.Password, f.Id as FavouritesId
          FROM Pets p
          LEFT JOIN Users u ON u.Id = p.Id_User
          LEFT JOIN AdType ad ON ad.Id = p.AdTypeId
          JOIN Favourites f ON f.PetCardId = p.Id and f.UserId = $user_id
        ";

    $pets = mysqli_query($connect, $query);
    while($pet = mysqli_fetch_assoc($pets)){
        $isFavourites = $pet['FavouritesId'] != null;
        
        $userId = $pet['UserId'];
		$user = mysqli_fetch_assoc(mysqli_query($connect, "select * from Users where Id = $userId"));
        
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$userId"));
        $user['UserDetails'] = $userDetails_get;

        $petsInfo['Pets'][] = [
            'Id' => $pet['Id'],
            'age' => $pet['Age'], 
            'adType' => $pet['AdTypeName'], 
            'breed' => $pet['Breed'],
            'veterinarian' => $pet['Veterinarian'],
            'petNickname' => $pet['petNickname'],
            'imageUrl' => $pet['imageUrl'],
            'petDescription' => $pet['petDescription'],
            'petPrice' => $pet['petPrice'],
            'petType' => $pet['petType'],
            'isFavourites' => $isFavourites,
            'User' => $user
            ];
    }
    //print_r($petsInfo);    
    echo json_encode($petsInfo, JSON_UNESCAPED_UNICODE);
        
?>