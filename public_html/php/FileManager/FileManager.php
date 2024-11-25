<?php

class FileManager {
    public function createDirectory($directoryPath) {
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteDirectory($directoryPath) {
        if (is_dir($directoryPath)) {
            $files = glob($directoryPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                } elseif (is_dir($file)) {
                    $this->deleteDirectory($file);
                }
            }
            rmdir($directoryPath);
            return true;
        } else {
            return false;
        }
    }
    
    public function uploadFile($filePath, $targetDirectory, $fileName = "default") {
        if (file_exists($filePath) && is_dir($targetDirectory)) {
            if($fileName == "default"){
                $fileName = basename($filePath);
            }
            $targetFilePath = $targetDirectory . '/' . $fileName;
        
            return move_uploaded_file($filePath, $targetFilePath);
        } else {
            return false;
        }
    }
    
    public function deleteFile($filePath) {
        if (file_exists($filePath) && is_file($filePath)) {
            return unlink($filePath);
        } else {
            return false;
        }
    }

    public function deleteAllFiles($directory){
        if (is_dir($directory)) {
            $files = glob($directory . '*');
            foreach ($files as $file) {
                deleteFile($file);
            }
            return true;
        }
        else{
            return false;
        }
    }
    
    public function moveFile($sourceFilePath, $targetFilePath) {
        if (file_exists($sourceFilePath) && is_file($sourceFilePath)) {
            return rename($sourceFilePath, $targetFilePath);
        } else {
            return false;
        }
    }   
    
}