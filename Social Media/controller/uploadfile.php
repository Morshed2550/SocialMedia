<?php

    $src = $_FILES['myfile']['tmp_name'];
    $des = "upload/".$_FILES['myfile']['name'];

   if(move_uploaded_file($src, $des)){
        echo "Uploaded";
   }else{
        echo "Error";
   }
?>
<html>
  <head>
    <title></title>
  </head>

  <body>
    <h1></h1>
    <br />
 
	<a href="../view/home.php">Go to Home</a><br />
  </body>
</html>
