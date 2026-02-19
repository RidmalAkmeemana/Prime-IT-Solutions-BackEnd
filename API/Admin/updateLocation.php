<?php

require '../../API/Connection/BackEndPermission.php';

$Id = $_POST['Id'];
$Postal_Code = $_POST['Postal_Code'];
$Location_Name = $_POST['Location_Name'];

if (empty($Id) || empty($Postal_Code) || empty($Location_Name)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_locations` WHERE `tbl_locations`.`Id` = '$Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Id exists, perform the update
        $updateQuery = "UPDATE `tbl_locations` SET `Postal_Code` = '$Postal_Code', `Location_Name` = '$Location_Name' WHERE `tbl_locations`.`Id` = '$Id';";
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
        $myObj->error = 'no_location_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>