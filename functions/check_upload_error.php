<?php

        if(empty($upload_error) ===true){
            
             if (is_image() ===false) {
              $upload_error[] = "File is not an image.";           
              # code...
            }
            if(file_type($imageFileType) === true){
              $upload_error[] = "JPG, JPEG, PNG & GIF files are allowed";
            }     
            if(file_exist($target_file) ===true){
              $upload_error[] = "File is already in use. Please choose another file.";
            }
            if(upload_size() ===true){
              $upload_error[] = "File is too large.";
            } 
          }         
    
?>