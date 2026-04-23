<?php

require '../../API/Connection/BackEndPermission.php';

$Individuals_Id = $_POST['Individuals_Id'];
$Status = $_POST['Status'];

if (empty($Individuals_Id) || empty($Status)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Individuals_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_individuals` WHERE `tbl_individuals`.`Individuals_Id` = '$Individuals_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Individuals_Id exists, perform the update
        $updateQuery = "UPDATE `tbl_individuals` SET `Status` = '$Status' WHERE `tbl_individuals`.`Individuals_Id` = '$Individuals_Id';";
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
        // If Individuals_Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_application_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>