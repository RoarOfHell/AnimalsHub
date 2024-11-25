<?php
    require_once 'vendor/connect.php';

    $query = "SELECT * FROM `AnimalsBreeds`";
    
    $result = mysqli_query($connect, $query);
    
	while($petBreed = mysqli_fetch_assoc($result)){
		$petsBreed["PetsBreed"][] = $petBreed;
	}
    
   
    echo json_encode($petsBreed, JSON_UNESCAPED_UNICODE);
        
?>