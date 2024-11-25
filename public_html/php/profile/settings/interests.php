<?php
    session_start();

    require_once "vendor/connect.php";

    $login = $_SESSION['user']->Login;
    $password = $_SESSION['user']->Password;

    $interests = mysqli_fetch_assoc(mysqli_query($connect, "SELECT pt.Title, ab.Breed FROM UserInterests ui 
    LEFT JOIN PetType pt ON pt.Id = ui.IdAnimal
    LEFT JOIN AnimalsBreeds ab ON ui.IdBreed = ab.Id
    WHERE UserId = (SELECT Id From Users WHERE Login = '$login' AND Password = '$password')"));

    $animalsType = [];

    $responcePets = mysqli_query($connect, "SELECT * FROM PetType");

    while($value = mysqli_fetch_assoc($responcePets)){
        $animalsType[] = $value;
    }

?>

<div class="w-100 h-100 vertical-box">
    <div class="pt-2 pb-2 ps-3">
        <strong>Интересы</strong>
    </div>
    <hr class="p-0 m-0">

    <div class="ps-3 pe-3 pt-3 w-100 h-100 vertical-box" style="overflow: hidden; overflow-y:auto;">
        <div class="vertical-box w-100 h-100">
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Любиное домашнее животное</span>
                <input type="text" list="animals" name="likeAnimal" id="petType" value="<?php echo $interests['Title']?>" style="color: black;" onvolumechange="selectPetType()" onkeyup="selectPetType()" autocomplete="off">
                <datalist id="animals">
                    <?php foreach($animalsType as $value): ?>
                        <option value="<?php echo $value['Title']; ?>"></option>
                    <?php endforeach; ?>
                </datalist> 
            </div>

            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Любиная порода домашнего животного</span>
                <input type="text" list="breeds" name="likeBreed" id="likebreed" value="<?php echo $interests['Breed']?>" style="color: black;" onkeyup="onChangeValueDetection()" autocomplete="off">
                <datalist id="breeds">
                    
                </datalist> 
            </div>

            <div class="w-100 vertical-box vertical-align-bottom">
                <button type="submit" class="btn btn-primary save-btn" style="visibility: collapse;" onclick="saveInterests()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script>
    let allBreeds = null;
    let allAnmals = null;

    fetch("https://api.animalshub.ru/GetAnimalsBreed.php", {method: "GET"}).then(x => x.json()).then(data => {
        allBreeds = data;
    });

    fetch("https://api.animalshub.ru/GetAllAnimalsType.php", {method: "GET"}).then(x => x.json()).then(data => {
        
        allAnmals = data;
    });
    
    function selectPetType(){
        const petType =document.getElementById("petType");
        const breeds = document.getElementById("breeds");
        const likebreed = document.getElementById("likebreed");
        let idPetType = 0;
        var datalistContent = "";
 
        allAnmals.PetsType.forEach(element => {
            
            if(element.Title.includes(petType.value)){
                idPetType = element.Id;
            }
        });
      
        allBreeds.PetsBreed.forEach(element => {
            if(element.IdTypePet == idPetType){
                datalistContent += `<option value="${element.Breed}"></option>`;
            }
        });

        likebreed.value = "";
        breeds.innerHTML = datalistContent;
        onChangeValueDetection();
    }

    async function saveInterests(){
        const likeAnimal = document.getElementsByName("likeAnimal")[0];
        const likeBreed = document.getElementsByName("likeBreed")[0];

        const formData = new FormData();
        
        formData.append("likeAnimal", likeAnimal.value.trim());
        formData.append("likeBreed", likeBreed.value.trim());


        const responce =await fetch("https://animalshub.ru/php/profile/settings/save/saveInterests.php", {
          method: "POST",
          body: formData
        });
        
        if(responce.ok){
          const result = await responce.text();
          console.log(result);
          onDropChangedValue();
        }
    }

    
</script>