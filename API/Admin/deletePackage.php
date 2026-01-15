<?php

require '../../API/Connection/BackEndPermission.php';

$Package_Id = $_POST['Package_Id'];

if (empty($Package_Id)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} else {
    // Check if Package_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_package` WHERE `tbl_package`.`Package_Id` = '$Package_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Package_Id exists, perform the delete
        $updateQuery = "DELETE FROM tbl_package WHERE Package_Id = '$Package_Id';";
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
        // If Package_Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_package_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>