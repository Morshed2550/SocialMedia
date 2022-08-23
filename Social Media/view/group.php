<?php 
require '../controller/functions.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
$temp = $_SESSION['user_id'];
session_destroy();
session_start();
$_SESSION['user_id'] = $temp;
ob_start(); 
// Establish Database Connection
$conn = connect();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/main.css">
</head>
<body>
    <div class="container">
        <?php include '../controller/navbar.php'; ?>
        <br>
        <div class="createpost">
            <form method="post" action="" onsubmit="return validatePost()" enctype="multipart/form-data">
                <h2>Group Post</h2>
                <hr>
                <span style="float:right; color:black">
                <input type="checkbox" id="public" name="public">
                <label for="public">Public</label>
                </span>
                Caption <span class="required" style="display:none;"> *You can't Leave the Caption Empty.</span><br>
                <textarea rows="6" name="caption"></textarea>
                <center><img src="" id="preview" style="max-width:580px; display:none;"></center>
                <div class="createpostbuttons">
                    <!--<form action="" method="post" enctype="multipart/form-data" id="imageform">-->
                    <label>
                        <img src="images/photo.png">
                        <input type="file" name="fileUpload" id="imagefile">
                        <!--<input type="submit" style="display:none;">-->
                    </label>
                    <input type="submit" value="Post" name="post">
                    <!--</form>-->
                </div>
            </form>
        </div>
        <?php 
        // Public Posts Union Friends' Private Posts
 
       
        ?>
        <br><br><br>
    </div>
    
    <script>
        // Invoke preview when an image file is choosen.
        $(document).ready(function(){
            $('#imagefile').change(function(){
                preview(this);
            });
        });
        // Preview function
        function preview(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (event){
                    $('#preview').attr('src', event.target.result);
                    $('#preview').css('display', 'initial');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        // Form Validation
        function validatePost(){
            var required = document.getElementsByClassName("required");
            var caption = document.getElementsByTagName("textarea")[0].value;
            required[0].style.display = "none";
            if(caption == ""){
                required[0].style.display = "initial";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Form is Posted
    // Assign Variables
    $caption = $_POST['caption'];
    if(isset($_POST['public'])) {
        $public = "Y";
    } else {
        $public = "N";
    }
    $poster = $_SESSION['user_id'];
    // Apply Insertion Query
    $sql = "INSERT INTO posts (post_caption, post_public, post_time, post_by)
            VALUES ('$caption', '$public', NOW(), $poster)";
    $query = mysqli_query($conn, $sql);
    // Action on Successful Query
    if($query){
        // Upload Post Image If a file was choosen
        if (!empty($_FILES['fileUpload']['name'])) {
            echo 'FUUUQ';
            // Retrieve Post ID
            $last_id = mysqli_insert_id($conn);
            include '../controller/upload.php';
        }
        header("location: home.php");
    }
}
?>