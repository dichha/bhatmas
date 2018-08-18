<?php

$upload_error = array();
$target_dir = "../shop/product/img/";
$target_file = "";
$imageFileType = "";

if(isset($_FILES['fileToUpload'])){
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
}
// Check if image file is a actual image or fake image

// Check if file already exists
function file_exist($target_file){
    if (file_exists($target_file)) {
    return true;
    }else{
        return false;
    }
}
// Allow certain file formats

function file_type($imageFileType){
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    return true;
    }else{
        return false;
    }
}

function is_image(){
    // check if file is image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        return true;
    } else {
        return false;
    }
}

function upload_size(){
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
    return true;
}else{
    return false;
}
}

function upload($target_file){

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        return true;
    } else {
        return false;
    }

}

?>