<?php

require '../../API/Connection/BackEndPermission.php';

$Postal_Code = $_POST['Postal_Code'];
$Location_Name = $_POST['Location_Name'];

if (empty($Postal_Code) || empty($Location_Name)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit();
} else {
    // Check if the Postal_Code already exists in the database
    $checkQuery = "SELECT * FROM `tbl_locations` WHERE `Postal_Code`='$Postal_Code'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If Postal_Code already exists, update the tbl_locations
        $sql = "UPDATE `tbl_locations` SET `Location_Name` = '$Location_Name' WHERE `tbl_locations`.`Postal_Code` = '$Postal_Code';";

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
        // If Postal_Code doesn't exist, insert into tbl_locations
        $sql1 = "INSERT INTO `tbl_locations` (`Postal_Code`, `Location_Name`) VALUES ('$Postal_Code', '$Location_Name')";

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
