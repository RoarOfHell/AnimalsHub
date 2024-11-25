<?php

function upload_image_to_directory($file, $directory, $is_md5 = false){
    $targetFile = basename($file['name']);
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    
    if($is_md5){
        $current_time = date("H:i:s.u");
        $targetFile = $directory . md5(basename($file['name']) . $current_time) . ".webp";
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return [
            "status" => "uploaded",
            "path" => $targetFile
        ];
    } 
    else{
        return [
            "status" => "error uploading image",
            "path" => $targetFile
        ];
    }
}

function remove_all_files_at_path($path){
    if (file_exists($path)) {
        $files = glob("$path*");

        foreach($files as $file){ 
          if(is_file($file)) {
            unlink($file);
          }
        }
    }
    
}