<?php

require '../../API/Connection/BackEndPermission.php';

$Id = $_POST['Id'];
$Addon_Name = $_POST['Addon_Name'];
$Addon_description = $_POST['Addon_description'];
$Addon_Price = $_POST['Addon_Price'];

if (empty($Id) || empty($Addon_Name) || empty($Addon_description) || empty($Addon_Price)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_addon` WHERE `tbl_addon`.`Id` = '$Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Id exists, perform the update
        $updateQuery = "UPDATE `tbl_addon` SET `Addon_Name` = '$Addon_Name', `Addon_description` = '$Addon_description', `Addon_Price` = '$Addon_Price' WHERE `tbl_addon`.`Id` = '$Id';";
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
        $myObj->error = 'no_addon_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>