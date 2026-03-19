<?php

require '../../API/Connection/BackEndPermission.php';

$Job_Type = $_POST['Job_Type'];

if (empty($Job_Type)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit();
} else {
    // Check if the Job_Type already exists in the database
    $checkQuery = "SELECT * FROM `tbl_types` WHERE `Job_Type`='$Job_Type'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If Job_Type already exists, update the tbl_types
        $sql = "UPDATE `tbl_types` SET `Job_Type` = '$Job_Type' WHERE `tbl_types`.`Job_Type` = '$Job_Type';";

        if (mysqli_query($conn, $sql)) {
            $myObj = new \stdClass();
            $myObj->success = 'true';
            echo json_encode($myObj);
        } else {
            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = 'update_failed_details';
            echo json_encode($myObj);
        }
    } else {
        // If Job_Type doesn't exist, insert into Job_Type
        $sql1 = "INSERT INTO `tbl_types` (`Job_Type`) VALUES ('$Job_Type')";

        if (mysqli_query($conn, $sql1)) {

            $myObj = new \stdClass();
            $myObj->success = 'true';
            echo json_encode($myObj);
        } else {

            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = 'insert_failed_location';
            echo json_encode($myObj);
        }
    }
}

mysqli_close($conn);
