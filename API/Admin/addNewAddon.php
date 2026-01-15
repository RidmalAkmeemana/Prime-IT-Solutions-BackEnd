<?php

require '../../API/Connection/BackEndPermission.php';

$Addon_Name = $_POST['Addon_Name'];
$Addon_description = $_POST['Addon_description'];
$Addon_Price = $_POST['Addon_Price'];

if (empty($Addon_Name) || empty($Addon_description) || empty($Addon_Price)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit();
} else {
    // Check if the Addon_Name already exists in the database
    $checkQuery = "SELECT * FROM `tbl_addon` WHERE `Addon_Name`='$Addon_Name'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If Addon_Name already exists, update the tbl_addon
        $sql = "UPDATE `tbl_addon` SET `Addon_description` = '$Addon_description', `Addon_Price` = '$Addon_Price'  WHERE `tbl_addon`.`Addon_Name` = '$Addon_Name';";

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
        // If Package_Id doesn't exist, insert into tbl_addon
        $sql1 = "INSERT INTO `tbl_addon` (`Addon_Name`, `Addon_description`, `Addon_Price`) VALUES ('$Addon_Name', '$Addon_description', '$Addon_Price')";

        if (mysqli_query($conn, $sql1)) {

            $myObj = new \stdClass();
            $myObj->success = 'true';
            echo json_encode($myObj);
        } else {

            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = 'insert_failed_addon';
            echo json_encode($myObj);
        }
    }
}

mysqli_close($conn);
