<?php
    require_once 'vendor/connect.php';

    $query = "SELECT * FROM `PetType`";
    
    $result = mysqli_query($connect, $query);
    
	while($petType = mysqli_fetch_assoc($result)){
		$petsType["PetsType"][] = $petType;
	}
  
    echo json_encode($petsType, JSON_UNESCAPED_UNICODE);
        
?>