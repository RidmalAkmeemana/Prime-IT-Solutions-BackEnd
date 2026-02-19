<?php

require '../../API/Connection/BackEndPermission.php';

$Id = $_POST['Id'];
$Department_Name = $_POST['Department_Name'];
$Department_description = $_POST['Department_description'];

if (empty($Id) || empty($Department_Name) || empty($Department_description)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_departments` WHERE `tbl_departments`.`Id` = '$Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Id exists, perform the update
        $updateQuery = "UPDATE `tbl_departments` SET `Department_Name` = '$Department_Name', `Department_description` = '$Department_description' WHERE `tbl_departments`.`Id` = '$Id';";
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
        $myObj->error = 'no_department_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>