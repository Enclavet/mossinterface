<?php
ini_set('display_errors', 'On');
include("moss.php");
$userid = "303531640"; // Enter your MOSS userid

function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir."/".$object))
           rrmdir($dir."/".$object);
         else
           unlink($dir."/".$object); 
       } 
     }
     rmdir($dir); 
   } else {
     unlink($dir);
   }
 }

if(isset($_GET['delete'])) {
    $path = "./uploads/".$_GET['delete'];
    rrmdir($path);
    echo $_GET['delete']." deleted!";
    header( "Location:index.php");
}

if(isset($_FILES['upload']['name'])) {
  $total = count($_FILES['upload']['name']);
  if($_POST['assignment'] != "") {
      $assigndir = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['assignment']);
  } else {
      $assigndir = "tmpdir".rand();
  }
  for($i=0; $i<$total; $i++) {
    $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
    if ($tmpFilePath != ""){
      if (!file_exists("./uploads/".$assigndir)) {
	mkdir("./uploads/".$assigndir, 0755, true);
      }
      $newFilePath = "./uploads/". $assigndir . "/" . $_FILES['upload']['name'][$i];
      move_uploaded_file($tmpFilePath, $newFilePath);
    }
  }

  $moss = new MOSS($userid);
  $moss->setLanguage($_POST['language']);
  $moss->addByWildcard("./uploads/".$assigndir."/*");
  $url = $moss->send();
  rrmdir("./uploads/".$assigndir); 
  header( "Location:".$url);
  
}

?>
