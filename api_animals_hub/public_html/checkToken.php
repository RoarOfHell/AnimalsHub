<?php 
	
    function check_token_api($connect, $token) {
        $tokens = mysqli_query($connect, "select * from Token where Token = '$token'");
        $tokenApiId =  mysqli_fetch_assoc(mysqli_query($connect, "select Id from SecretKeysType where Name = 'api' or Name = 'API'"))['Id'];

        if(mysqli_num_rows($tokens) > 0){
            while($row = mysqli_fetch_assoc($tokens)){
                if($row['IdTypeToken'] == $tokenApiId){
                    return "seccess";
                }
            }
            
        }
        else{
            return "failure";
        }

        
    }
 ?>