<?php 

function GetCard($pet){

    if ($pet[10] == '1') {
        echo '
        <div id="pet-id-'.$pet[0].'" class="m-2 cursor-pointer preview-slot" onclick="showPetCardDialog(this)">
          <img class="w-100 h-100 cursor-pointer preview-slot" style="object-fit: cover;" src="'.$pet[2].'" alt="Animal Photo" class="animal-photo">
        </div>
        ';
      } else if ($pet->adType === 'Продажа') {
        echo '
        <div id="pet-id-'.$pet[0].'" class="m-2 cursor-pointer preview-slot" onclick="showPetCardDialog(this)">
          <img class="w-100 h-100 cursor-pointer preview-slot" style="object-fit: cover;" src="'.$pet[2].'" alt="Animal Photo" class="animal-photo">
        </div>
        ';
      } else {
        echo '
        <div id="pet-id-'.$pet[0].'" class="m-2 cursor-pointer preview-slot" onclick="showPetCardDialog(this)">
          <img class="w-100 h-100 cursor-pointer preview-slot" style="object-fit: cover;" src="'.$pet[2].'" alt="Animal Photo" class="animal-photo">
        </div>
        ';
      }
}

function GetCardAtName($pet){
  if ($pet['adType'] == 'Потеряшка') {
      echo '
        <div id="pet-id-'.$pet['Id'].'" class="animal-card" onclick="showPetCardDialog(this)">
          <img src="'.$pet['imageUrl'].'" alt="Animal Photo" class="animal-photo">
          <p class="animal-name">'.$pet['petNickname'].'</p>
          <div class="animal-details">
            <p>Тип: '.$pet['petType'].'</p>
            <p>Порода: '.$pet['breed'].'</p>
            <p>Возраст: '.$pet['age'].'</p>
          </div>
          <div class="animal-price">'.$pet['petPrice'].' руб</div>
          <div class="animal-buttons">
            <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify('.$pet['Id'].'))"><i class="fa fa-heart" aria-hidden="true"></i></button>
          </div>
          <div class="ribbon">Потерян</div>
        </div>
      ';
    } else if ($pet->adType === 'Продажа') {
      echo '
        <div id="pet-id-'.$pet['Id'].'" class="animal-card" onclick="showPetCardDialog(this)">
          <img src="'.$pet['imageUrl'].'" alt="Animal Photo" class="animal-photo">
          <p class="animal-name">'.$pet['petNickname'].'</p>
          <div class="animal-details">
            <p>Тип: '.$pet['petType'].'</p>
            <p>Порода: '.$pet['breed'].'</p>
            <p>Возраст: '.$pet['age'].'</p>
          </div>
          <div class="animal-price">'.$pet['petPrice'].' руб</div>
          <div class="animal-buttons">
            <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify('.$pet['Id'].'))"><i class="fa fa-heart" aria-hidden="true"></i></button>
          </div>
        </div>
      ';
    } else {
      echo '
        <div id="pet-id-'.$pet['Id'].'" class="animal-card" onclick="showPetCardDialog(this)">
          <img src="'.$pet['imageUrl'].'" alt="Animal Photo" class="animal-photo">
          <p class="animal-name">'.$pet['petNickname'].'</p>
          <div class="animal-details">
            <p>Тип: '.$pet['petType'].'</p>
            <p>Порода: '.$pet['breed'].'</p>
            <p>Возраст: '.$pet['age'].'</p>
          </div>
          <div class="animal-price">Бесплатно</div>
          <div class="animal-buttons">
            <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify('.$pet['Id'].'))"><i class="fa fa-heart" aria-hidden="true"></i></button>
          </div>
        </div>
      ';
    }
}