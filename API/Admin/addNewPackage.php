<?php

require '../../API/Connection/BackEndPermission.php';

$Package_Id = $_POST['Package_Id'];
$Package_Name = $_POST['Package_Name'];
$Package_Description = $_POST['Package_Description'];
$Price = $_POST['Price'];

if (empty($Package_Id) || empty($Package_Name) || empty($Package_Description) || empty($Price)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit();
} else {
    // Check if the Package_Id already exists in the database
    $checkQuery = "SELECT * FROM `tbl_package` WHERE `Package_Id`='$Package_Id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If Package_Id already exists, update the tbl_package
        $sql = "UPDATE `tbl_package` SET `Package_Description` = '$Package_Description', `Price` = '$Price'  WHERE `tbl_package`.`Package_Id` = '$Package_Id';";

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
        // If Package_Id doesn't exist, insert into tbl_package
        $sql1 = "INSERT INTO `tbl_package` (`Package_Id`, `Package_Name`, `Package_Description`, `Price`) VALUES ('$Package_Id', '$Package_Name', '$Package_Description', '$Price')";

        if (mysqli_query($conn, $sql1)) {

            $myObj = new \stdClass();
            $myObj->success = 'true';
            echo json_encode($myObj);
        } else {

            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = 'insert_failed_package';
            echo json_encode($myObj);
        }
    }
}

mysqli_close($conn);
