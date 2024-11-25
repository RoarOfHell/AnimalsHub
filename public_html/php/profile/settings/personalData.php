<?php
session_start();


require_once "vendor/connect.php";
require_once "php/GetUserInfo.php";
require_once "php/splitedData/Cities/getCountryAndCity.php";

$area = count(explode("обл", $_SESSION['user']->UserDetails->City)) > 0 ? explode("обл", $_SESSION['user']->UserDetails->City)[0] . "обл." : "";
$city = count(explode("обл", $_SESSION['user']->UserDetails->City)) > 1 ? trim(str_replace(".", "", explode("обл", $_SESSION['user']->UserDetails->City)[1])) : "";

$cities = getAllCity($connect);
$regions = getAllRegions($connect);

?>

<div class="w-100 h-100 vertical-box">
    <div class="pt-2 pb-2 ps-3">
        <strong>Личные данные</strong>
    </div>
    <hr class="p-0 m-0">

    <div class="ps-3 pe-3 pt-3 w-100 h-100 vertical-box" style="overflow: hidden; overflow-y:auto;">
        <div class="vertical-box w-100 h-100">
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Фамилия</span>
                <input type="text" name="middleName" id="" value="<?php echo $_SESSION['user']->UserDetails->MiddleName?>" style="color: black;" onkeyup="onChangeValueDetection()">
            </div>
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Имя</span>
                <input type="text" name="name" id="" value="<?php echo $_SESSION['user']->UserDetails->Name?>" style="color: black;" onkeyup="onChangeValueDetection()">
            </div>
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Почта</span>
                <div class="horizontal-box w-100">
                    <input <?php echo ($_SESSION['user']->IsConfirmMail == 0 ? "" : "disabled")?> type="email" class="w-100 me-2" name="email" id="email" style="color: black;" title="<?php echo ($_SESSION['user']->IsConfirmMail == 0 ? "" : "Отвяжите почту чтобы изменить её")?>" value="<?php echo $_SESSION['user']->UserDetails->Mail?>" onkeyup="onChangeValueDetection()">
                    <input type="button" class="btn btn-primary" value="<?php echo ($_SESSION['user']->IsConfirmMail == 0 ? "Привязать" : "Отвязать")?>" onclick="emaillink()">
                </div>
            </div>
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Номер телефона</span>
                <input type="text" name="phoneNum" id="" style="color: black;" value="<?php echo $_SESSION['user']->UserDetails->NumPhone?>" onkeyup="onChangeValueDetection()">
            </div>
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Область</span>
                <input list="regions" type="text" name="region" id="" style="color: black;" value="<?php echo $area;?>"  autocomplete="off" onkeyup="onChangeValueDetection()">
                <datalist id="regions">
                <?php foreach($regions as $value): ?>
                        <option value="<?php echo $value['Name']; ?>"></option>
                    <?php endforeach; ?>
                </datalist>  
            </div>
            <div class="vertical-box w-100 pb-2 pt-2">
                <span>Город</span>
                <input list="city" type="text" name="city" id="" style="color: black;" value="<?php echo $city;?>"  autocomplete="off" onkeyup="onChangeValueDetection()">
                <datalist id="city">
                <?php foreach($cities as $value): ?>                             
                    <option value="<?php echo $value['Name']; ?>"></option>                        
                    <?php endforeach; ?>
                </datalist> 
            </div>
            <div class="w-100 vertical-box vertical-align-bottom">
                <button type="submit" class="btn btn-primary save-btn" style="visibility: collapse;" onclick="savePersonalData()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script>
    

    if(window.location.href == "https://animalshub.ru/profileSettings?refresh=1"){
        //window.location.href = "https://animalshub.ru/profileSettings";
    }

    async function emaillink(){
        const mailInput =document.getElementById("email");
        const formData = new FormData();

        formData.append("login", session.Login);
        formData.append("token", token);
        formData.append("mail", mailInput.value);
        formData.append("typeKey", 2);

        const responce = await fetch("https://api.animalshub.ru/SendSecretKeyToMail.php", {
            method: "POST",
            body: formData
        });

        if(responce.ok){

        }

        alert("На ваш электронный адрес было отправлено электронное письмо с подтверждением");

        session = await getDataSession("user", token);

        window.location.href = "https://animalshub.ru/profileSettings";
    }

    async function savePersonalData(){
        const middleName = document.getElementsByName("middleName")[0];
        const name = document.getElementsByName("name")[0];
        const email = document.getElementsByName("email")[0];
        const phoneNum = document.getElementsByName("phoneNum")[0];
        const region = document.getElementsByName("region")[0];
        const city = document.getElementsByName("city")[0];
        
        const formData = new FormData();
        
        formData.append("middleName", middleName.value.trim());
        formData.append("name", name.value.trim());
        formData.append("email", email.value.trim());
        formData.append("phoneNum", phoneNum.value.trim());
        formData.append("region", region.value.trim());
        formData.append("city", city.value.trim());

        const responce =await fetch("https://animalshub.ru/php/profile/settings/save/savePersonalData.php", {
          method: "POST",
          body: formData
        });
        
        if(responce.ok){
          const result = await responce.text();
          
          onDropChangedValue();
        }
    }
</script>