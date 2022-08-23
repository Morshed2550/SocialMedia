<?php

$target = glob("../asset/images/profiles/" . $row['user_id'] . ".*");
if($target) {
    echo '<img src="' . $target[0] . '" width="' . $width . '" height="' . $height .'">'; 
} else {
    if($row['user_gender'] == 'M') {
        echo '<img src="../asset/images/profiles/M.jpg" width="' . $width . '" height="' . $height .'">';
    } else if ($row['user_gender'] == 'F') {
        echo '<img src="../asset/images/profiles/F.jpg" width="' . $width . '" height="' . $height .'">';
    }
}

?>