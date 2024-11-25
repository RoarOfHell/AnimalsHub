<?php
    require_once 'vendor/connect.php';

    $user_id = mysqli_real_escape_string($connect, $_POST['userid']);
    $pageNum = mysqli_real_escape_string($connect, $_POST['pageNum']);
    $countCardAtPage = mysqli_real_escape_string($connect, $_POST['countCardAtPage']);
    $offset = $countCardAtPage * ($pageNum-1);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $query = "SELECT p.Id, ad.Name as AdTypeName, p.petNickname, p.imageUrl, p.petDescription, p.Age, p.Breed, p.petPrice, p.Veterinarian, p.petType, u.Id as UserId, u.Password, u.Login, f.Id as FavouritesId
          FROM Pets p
          LEFT JOIN Users u ON u.Id = p.Id_User
          LEFT JOIN AdType ad ON ad.Id = p.AdTypeId
          LEFT JOIN Favourites f ON f.PetCardId = p.Id and f.UserId = $user_id
          LIMIT $countCardAtPage OFFSET $offset
          ORDER BY p.Id
        ";

    $pets = mysqli_query($connect, $query);
    
    $images = mysqli_query($connect, "select * from PetImages");
    $imagesList = [];
    while($img = mysqli_fetch_assoc($images)){
    	$imagesList[] = $img;
    }
    
    
    while($pet = mysqli_fetch_assoc($pets)){
        $isFavourites = $pet['FavouritesId'] != null;
		$userId = $pet['UserId'];
		$user = mysqli_fetch_assoc(mysqli_query($connect, "select * from Users where Id = $userId"));
        
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$userId"));
        $user['UserDetails'] = $userDetails_get;
        
        $imagesArray = [];

		foreach ($imagesList as $image){
			if($image['PetCardId'] == $pet['Id']){
				$imagesArray[] = $image['ImageUrl'];
			}
		}


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
            'petImages' => $imagesArray,
            'petType' => $pet['petType'],
            'isFavourites' => $isFavourites,
            'User' => $user
            ];
    }
    //print_r($petsInfo);    
    echo json_encode($petsInfo, JSON_UNESCAPED_UNICODE);
        
?>