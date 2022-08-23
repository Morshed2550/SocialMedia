<?php
require '../controller/functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
$conn = connect();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/main.css">
</head>
<body>
    <div class="container">
        <?php include '../controller/navbar.php'; ?>
        <h1>Search Results</h1>
        <?php
            $location = $_GET['location'];
            $key = $_GET['query'];
            if($location == 'emails') {
                $sql = "SELECT * FROM users WHERE users.user_email = '$key'";
                include '../controller/userquery.php';
            } else if($location == 'names') {
                $name = explode(' ', $key, 2);
                if(empty($name[1])) {
                    $sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' OR users.user_lastname= '$name[0]'";
                } else {
                    $sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' AND users.user_lastname= '$name[1]'";
                }
                include '../controller/userquery.php';
            
                $query = mysqli_query($conn, $sql);
                $width = '40px'; 
                $height = '40px';
                if(!$query){
                    echo mysqli_error($conn);
                }
                if(mysqli_num_rows($query) == 0){
                    echo '<div class="post">';
                    echo 'There is no results given the keyword, try to widen your search query.';
                    echo '</div>';
                    echo '<br>';
                }
                while($row = mysqli_fetch_assoc($query)){
                    include '../controller/post.php';
                    echo '<br>';
                }
            }    
        ?>
    </div>
</body>
</html>
