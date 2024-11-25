<?php

function getParameterAtId($connect, $id){
    $parameter = mysqli_fetch_assoc(mysqli_query($connect, "SELECT Name FROM SettingsParameter WHERE Id = $id"))['Name'];

    return $parameter;
}

function getIdAtParameter($connect, $parameter){
    $id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT Id FROM SettingsParameter WHERE Name = $parameter"))['Id'];

    return $id;
}

function getAllParameters($connect){
    $responce = mysqli_query($connect, "SELECT * FROM SettingsParameter");
    $parametrs = [];
    while($value = mysqli_fetch_assoc($responce)){
        $parametrs[] = $value;
    }
    

    return $parametrs;
}

function getIdAtParameterInArray($array, $parameter){
    foreach ($array as $key => $value) {
       if($value['Name'] == $parameter){
            return $value['Id'];
       }
    }

    return 1;
}