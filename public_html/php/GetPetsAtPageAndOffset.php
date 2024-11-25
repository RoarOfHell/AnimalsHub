<?php
    
function getPets($connect, $user_id, $pageNum, $countCardAtPage){
    $offset = $countCardAtPage * ($pageNum-1);

    
    $query = "SELECT p.Id, ad.Name as AdTypeName, p.petNickname, p.imageUrl, p.petDescription, p.Age, p.Breed, p.petPrice, p.Veterinarian, p.petType, u.Id as UserId, u.Password, u.Login, f.Id as FavouritesId
          FROM Pets p
          LEFT JOIN Users u ON u.Id = p.Id_User
          LEFT JOIN AdType ad ON ad.Id = p.AdTypeId
          LEFT JOIN Favourites f ON f.PetCardId = p.Id and f.UserId = $user_id
          ORDER BY p.Id
          LIMIT $countCardAtPage OFFSET $offset
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
   
    return $petsInfo;
}
       
function paginationList($connect, $pageNum, $countCardAtPage){
    $countCards = mysqli_fetch_assoc(mysqli_query($connect, "SELECT Count(*) as count FROM Pets"))['count'];

    $maxPages = $countCards % $countCardAtPage == 0 ? $countCards / $countCardAtPage : (int)($countCards / $countCardAtPage) + 1;


    $list = '<nav>
    <ul class="pagination">
      <li class="page-item"><a class="page-link '.($pageNum <= 1 ? "disabled" : "").'" href="cards?page='.($pageNum-1).'">Предыдущая</a></li>';

      if($pageNum - 4 >= 1){
        $list .= '<li class="page-item"><a class="page-link" href="cards?page=1">1</a></li> ... ';
      }
      else{
        $list .= '<li class="page-item"><a class="page-link '.($pageNum == 1 ? "active" : "").'" href="cards?page=1">1</a></li>';
      }

      if($maxPages > 1){
        for ($index = $pageNum-2 <= 2? 2 : $pageNum-2; $index < ($pageNum+3 >= $maxPages ? $maxPages : $pageNum+($pageNum <= 1? 3 : 2)); $index++){
            if($index >= ($pageNum+2 >= $maxPages ? $maxPages : $pageNum+2) ){
                $list .= '<li class="page-item"><a class="page-link '.($pageNum == $index ? "active" : "").'" href="cards?page='.$index.'">'.($index).'</a></li>';
            }
            else{
                $list .= '<li class="page-item"><a class="page-link '.($pageNum == $index ? "active" : "").'" href="cards?page='.$index.'">'.$index.'</a></li>';
            }
            
        }
    
        if($pageNum+3 >= $maxPages){
            $list .= '<li class="page-item"><a class="page-link '.($pageNum == $maxPages ? "active" : "").'" href="cards?page='.$maxPages.'">'.($maxPages).'</a></li>';
        }
        else{
            $list .= '... <li class="page-item"><a class="page-link" href="cards='.$maxPages.'">'.$maxPages.'</a></li>';
        }
      }
    

    $list .= '<li class="page-item"><a class="page-link '.($pageNum >= $maxPages ? "disabled" : "").'" href="cards?page='.($pageNum+1).'">Следующая</a></li>
    </ul>
  </nav>';

  return $list;
}
?>