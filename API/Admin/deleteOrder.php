<?php

require '../../API/Connection/BackEndPermission.php';

$Order_Id = $_POST['Order_Id'];

if (empty($Order_Id)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} else {
    // Check if Order_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_orders` WHERE `tbl_orders`.`Order_Id` = '$Order_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Order_Id exists, perform the delete
        $updateQuery = "DELETE FROM tbl_orders WHERE Order_Id = '$Order_Id';";
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
        // If Order_Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_order_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>