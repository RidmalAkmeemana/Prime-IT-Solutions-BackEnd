<?php

require '../../API/Connection/BackEndPermission.php';

$Id = $_POST['Id'];
$Job_Type = $_POST['Job_Type'];

if (empty($Id) || empty($Job_Type)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_types` WHERE `tbl_types`.`Id` = '$Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Id exists, perform the update
        $updateQuery = "UPDATE `tbl_types` SET `Job_Type` = '$Job_Type' WHERE `tbl_types`.`Id` = '$Id';";
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
        $myObj->error = 'no_job_type_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>