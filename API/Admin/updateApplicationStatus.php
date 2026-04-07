<?php

require '../../API/Connection/BackEndPermission.php';

$Application_Id = $_POST['Application_Id'];
$Status = $_POST['Status'];

if (empty($Application_Id) || empty($Status)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Application_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_applications` WHERE `tbl_applications`.`Application_Id` = '$Application_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Application_Id exists, perform the update
        $updateQuery = "UPDATE `tbl_applications` SET `Status` = '$Status' WHERE `tbl_applications`.`Application_Id` = '$Application_Id';";
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
        // If Application_Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_application_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>