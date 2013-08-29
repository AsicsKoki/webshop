<?php
  function fileUpload(){
    if ($_FILES["file"]["error"] > 0) {
      return false;
     }

    $suffix = "";
    while(file_exists("../files/" . $_FILES["file"]["name"] . $suffix)){
      if($suffix == ""){
        $suffix = 1;
      } else {
        $suffix++;
      }
    }
    move_uploaded_file($_FILES["file"]["tmp_name"], "../files/" . $_FILES["file"]["name"] . $suffix);
    return $_FILES["file"]["name"] . $suffix;
  }
?>