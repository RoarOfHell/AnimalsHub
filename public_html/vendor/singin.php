<?php
    session_start();
    require_once 'connect.php';
    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = $_POST['password'];
    
    $password = md5($password);
    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
    
    
    if(mysqli_num_rows($check_user) > 0){
        
        $user = mysqli_fetch_assoc($check_user);
        $idU = $user['Id'];
        $userInfo = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$idU"));
        $_SESSION['user'] = [
            "userAccount" => $user,
            "userDetails" => $userInfo
            ];
      
            header('Location: https://animalshub.ru/');
    }
    else{
    	
       $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: https://animalshub.ru/'); 
    }
    

?>