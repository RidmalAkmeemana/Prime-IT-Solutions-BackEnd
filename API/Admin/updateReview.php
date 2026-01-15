<?php

require '../../API/Connection/BackEndPermission.php';

$Id = $_POST['Id'];
$Is_Approved = $_POST['Is_Approved'];

if (!isset($Id) || !isset($Is_Approved)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_reviews` WHERE `tbl_reviews`.`Id` = '$Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Id exists, perform the update
        $updateQuery = "UPDATE `tbl_reviews` SET `Is_Approved` = '$Is_Approved' WHERE `tbl_reviews`.`Id` = '$Id';";
        if (mysqli_query($conn, $updateQuery)) {
            $myObj = new \stdClass();
            $myObj->success = 'true';
            $myJSON = json_encode($myObj);
            echo $myJSON;
        } else {
            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    } else {
        // If Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_review_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>