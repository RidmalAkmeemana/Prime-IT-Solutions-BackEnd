<?php

require '../../API/Connection/BackEndPermission.php';

$Department_Name = $_POST['Department_Name'];
$Department_description = $_POST['Department_description'];

if (empty($Department_Name) || empty($Department_description)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit();
} else {
    // Check if the Department_Name already exists in the database
    $checkQuery = "SELECT * FROM `tbl_departments` WHERE `Department_Name`='$Department_Name'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If Department_Name already exists, update the tbl_departments
        $sql = "UPDATE `tbl_departments` SET `Department_description` = '$Department_description' WHERE `tbl_departments`.`Department_Name` = '$Department_Name';";

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
        // If Department_Name doesn't exist, insert into tbl_departments
        $sql1 = "INSERT INTO `tbl_departments` (`Department_Name`, `Department_description`) VALUES ('$Department_Name', '$Department_description')";

        if (mysqli_query($conn, $sql1)) {

            $myObj = new \stdClass();
            $myObj->success = 'true';
            echo json_encode($myObj);
        } else {

            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = 'insert_failed_department';
            echo json_encode($myObj);
        }
    }
}

mysqli_close($conn);
