<?php

require '../../API/Connection/BackEndPermission.php';

$Applicant_Id = $_POST['Id'];

if (empty($Applicant_Id)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} else {
    // Check if Applicant_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_applicants` WHERE `tbl_applicants`.`Applicant_Id` = '$Applicant_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Applicant_Id exists, perform the delete
        $updateQuery = "DELETE FROM tbl_applicants WHERE Applicant_Id = '$Applicant_Id';";
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
        // If Applicant_Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_applicant_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>