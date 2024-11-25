<?php

function getUser($connect, $login, $pass){
  $userResult = mysqli_query($connect, "select Id from Users where Login = '$login' and Password = '$pass'");
    
    
    if(mysqli_num_rows($userResult) == 0){
        echo "Error. No Correct Login Of Password";
        return null;
    }
    return mysqli_fetch_assoc($userResult)['Id'];
}

function getAllChats($connect, $user){
	// Запрашиваем список чатов и сообщений
	$query = "SELECT c.Id, c.Id_User1, c.Id_User2, m.Id AS message_Id, m.Id_Sender, m.IsChecked, m.Message, m.DateTime 
	          FROM Chats c 
	          LEFT JOIN Messages m ON m.Id_Chat = c.Id
	          WHERE c.Id_User1 = $user OR c.Id_User2 = $user
	          ORDER BY c.Id, m.DateTime
	        ";
	$result = mysqli_query($connect, $query);
	
	
	// Создаем массив чатов и сообщений
	$rows = [];
	$chats = [];
	$current_chat = null;
	while ($row = mysqli_fetch_array($result)) {
	    $rows[] = $row;
	}
	
	for($i = 0; $i < count($rows); $i++){
	    $row = $rows[$i];
	    if($current_chat == null || $row['Id'] != $current_chat['id']){
	        $current_chat = [
	            'id' => (int)$row['Id'],
	            'id_User1' => getUserById((int)$row['Id_User1'], $connect),
	            'id_User2' => getUserById((int)$row['Id_User2'], $connect),
	            'messages' => [],
	        ];
	        $message['messages'] = array();
	        
	    }
	    if($row['message_Id'] !== null){
	       $message = [
	                    'id' => (int)$row['message_Id'],
	                    'id_Sender' => (int)$row['Id_Sender'],
	                    'IsChecked' => (bool)$row['IsChecked'],
	                    'Message' => $row['Message'],
	                    'DateTime' => $row['DateTime'],
	                ]; 
	    }
	    $current_chat['messages'][] = $message;
	    if($i+1 == count($rows)){
	        $chats['chats'][] = $current_chat;
	    }
	    else if($row['Id'] !== $rows[$i+1]['Id']){
	       $chats['chats'][] = $current_chat; 
	    }
	}
	
	return $chats;
}

function getUserById($id, $connect) {
        $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM Users WHERE Id = $id"));
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$id"));
        $user['UserDetails'] = $userDetails_get;
        return $user;
    }
?>