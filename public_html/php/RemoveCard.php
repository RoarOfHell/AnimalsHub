<?php
    require_once '../vendor/connect.php';
    require 'checkToken.php';
    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $petId = mysqli_real_escape_string($connect, $_POST['petId']);
    $token = mysqli_real_escape_string($connect, $_POST['token']);


    if(check_token_api($connect, $token) == "seccess"){
        $user_info = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
        if(mysqli_num_rows($user_info) > 0){
            $user_id = mysqli_fetch_assoc($user_info)['Id'];
            $query = "DELETE FROM `Pets` WHERE Id = $petId and Id_User = $user_id";
         
            mysqli_query($connect, $query);
            
            mysqli_query($connect, "DELETE FROM `PetImages` WHERE PetCardId = $petId");
            
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user_id . '/petImages/'. $petId . '/';
            
            Delete($target_dir);
            
            echo 'complited';
        }
        else{
            echo 'login or password error';
            exit();
        }
    }
    


function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }
        return rmdir($path);
    }
    else if (is_file($path) === true)
    {
        return unlink($path);
    }
    return false;
}
    
php?>

