<?php
session_start();
require('mail.php');

    require_once 'vendor/connect.php';

    require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $email = mysqli_real_escape_string($connect, $_POST['mail']);
    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    
    $keyType = 1;
    
    if($_POST['typeKey'] != null){
    	$keyType = $_POST['typeKey'];
    }
    
    $sender = new SendMessageMail();
    $user_id = getUserIdAtEmail($connect, $email);
    if($user_id != "there is no user with such mail"){
    	

    	//$sender->send("почта", "ничего","Заголовок", "Сообщение","Неизвестно");
    	switch ($keyType) {
    		case 1:
    			$secretKey = generateRandomString();
    			addKeyToDataBase($connect, 1, $user_id, $secretKey, 1);
    			$sender->send($email, "test1","Reset password", getFormatCodeMessageHTML($secretKey, $email),"test4");
    			break;
    		case 2:
    			$secretKey = md5(generateRandomString(12));
    			addKeyToDataBase($connect, 2, $user_id, $secretKey, 1);
    			$email_message = "https://api.animalshub.ru/MailToken.php?login=$login&typeKey=2&key=$secretKey";
    			$sender->send($email, "test1","Confirm email", getFormatUrlMessageHTML($email_message, $email),"test4");
    			break;
    		default:
    			// code...
    			break;
    	}
    	
    }
    



function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function addKeyToDataBase($connect, $keyType = 1, $user_id, $secretKey, $intervalHour = 1){
	$check_user_in_secret_key = mysqli_query($connect, "select * from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$keyType'");
		if(mysqli_num_rows($check_user_in_secret_key) > 0){
			mysqli_query($connect, "delete from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$keyType'");
		}
	
	mysqli_query($connect, "INSERT INTO `UsersConfirmKey` (`UserId`, `IdTypeKey`, `SecretKey`, `DateTimeCreate`, `DateTimeRemove`) 
		VALUES ('$user_id', '$keyType', '$secretKey', NOW(), DATE_ADD(NOW(), INTERVAL $intervalHour hour));");
}

function getUserIdAtEmail($connect, $email){
	$check_user = mysqli_query($connect, "select * from UserDetails where Mail='$email'");

    if(mysqli_num_rows($check_user) > 0){
    	return mysqli_fetch_assoc($check_user)['UserId'];
    }
    else{
        echo 'there is no user with such mail';
        return "there is no user with such mail";
    }
}


function getFormatUrlMessageHTML($message, $email){
	
	$result = '<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        .bodys {
            margin: 0px; padding: 0px; box-sizing: border-box; font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        .panel1 {
            display: flex; align-items: center; justify-content: center;
        }
        .panel2 {
            display: flex; background-color: #fff; width: 650px; height: 450px; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0px 1px 40px 1px rgb(0 0 0 / 35%);
        }
        .panel3 {
            display: flex; flex-direction: column; width: 610px; height: 430px; row-gap: 20px;
        }
        .imagePanel {
            display: flex; justify-content: center; left: 50%;
        }
    </style>
    <title>Document</title>
</head>
<body class="bodys">
    <center>
        <div class="panel1">
            <div class="panel2">
                <div class="panel3">
                    <div class="imagePanel">
                        <img src="https://animalshub.ru/images/icons/app-icon/app-icon.png" style="width: 60px; height: 60px;">
                    </div>
                    <h3 style="font-weight: normal;">Здравствуйте!</h3>
                    <h4 style="font-weight: normal;">Чтобы подтвердить свой адрес электронной почты и получить доступ к полной функциональности нашего сайта, пожалуйста, перейдите по ссылке:<br><br><a style="text-decoration: none; color: #5a6197; font-weight: bold;" href="'. $message .'">'. $message .'</a></h5>
                    <h4 style="font-weight: normal;">Пожалуйста, перейдите по этой ссылке в течение часа, так как она действительна только в течение этого времени.
                        Если у вас возникнут какие-либо вопросы или проблемы с подтверждением своей электронной почты, не стесняйтесь связаться с нами.
                    </h4>
                    <i style="margin-top: auto;"><h4 style="font-weight: normal;">Спасибо за использование наших услуг!,<br><br>
                        С уважением,
                        <a style="text-decoration: none; color: #5a6197;" href="https://animalshub.ru/">Animalshub.ru</a>
                    </h4>
                </i>
                </div>
            </div>
       </div>
    </center>
</body>
</html>';
   
   return $result;
	
}


function getFormatCodeMessageHTML($message, $email){
	
	$result = '
	<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        .bodys {
            margin: 0px; padding: 0px; box-sizing: border-box; font-family: Poppins, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        .panel1 {
            display: flex; align-items: center; justify-content: center;
        }
        .panel2 {
            display: flex; background-color: #fff; width: 650px; height: 450px; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0px 1px 40px 1px rgb(0 0 0 / 35%);
        }
        .panel3 {
            display: flex; flex-direction: column; width: 610px; height: 430px; row-gap: 20px;
        }
        .imagePanel {
            display: flex; justify-content: center; left: 50%;
        }
    </style>
    <title>Document</title>
</head>
<body class="bodys">
    <center>
    <div class="panel1">
        <div class="panel2">
            <div class="panel3">
                <div class="imagePanel">
                <center><img src="https://animalshub.ru/images/icons/app-icon/app-icon.png" style="width: 60px; height: 60px;"></center>
                </div>
                <h3 style="font-weight: normal;">Здравствуйте!</h3>
                <h4 style="font-weight: normal;">Вы запросили восстановление пароля для своей учетной записи. 
                    Для продолжения процедуры восстановления, пожалуйста, введите следующий код подтверждения: <br><br>
                    <div style="font-size: 2em; left: 50%; color: #5a6197; letter-spacing: .2em;">
                        <center>'.$message.'</center>
                    </div>
                </h5>
                <h4 style="font-weight: normal;">Обратите внимание, что данный код будет действительным только в течение одного часа. 
                    Если вы не запрашивали восстановление пароля, проигнорируйте это сообщение.
                </h4>
                <i style="margin-top: auto;"><h4 style="font-weight: normal;">Спасибо за использование наших услуг!,<br><br>
                    С уважением,
                    <a style="text-decoration: none; color: #5a6197;" href="https://animalshub.ru/">Animalshub.ru</a>
                </h4>
            </i>
            </div>
        </div>
    </div>
    </center>
</body>
</html>';
   
   return $result;
	
}








?>