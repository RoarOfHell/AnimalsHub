<?php

function get_user_role($connect, $user_id){
    $userRole = mysqli_fetch_assoc(mysqli_query($connect,"SELECT (select name from UserRoles where Id = IdRole) as RoleName FROM UsersRole WHERE IdUser = $user_id"))['RoleName'];
    return $userRole == '' ? 'user' : $userRole;
}