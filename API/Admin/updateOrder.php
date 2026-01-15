<?php

require '../../API/Connection/BackEndPermission.php';

$Order_Id = $_POST['Order_Id'];
$Status = $_POST['Status'];
$Reject_Cancel_Reason = $_POST['Reject_Cancel_Reason'];

// Validate required fields
if (empty($Order_Id) || empty($Status)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit;
}

// Check if Order_Id exists
$checkQuery = "SELECT * FROM `tbl_orders` WHERE `Order_Id` = '$Order_Id';";
$result = mysqli_query($conn, $checkQuery);

if ($result && mysqli_num_rows($result) > 0) {

    // Sanitize input
    $Reject_Cancel_Reason = mysqli_real_escape_string($conn, trim($Reject_Cancel_Reason));
    $Reject_Cancel_Reason = ($Reject_Cancel_Reason === '') ? NULL : $Reject_Cancel_Reason;

    //Perform update
    $updateQuery = "
        UPDATE `tbl_orders`
        SET 
            `Status` = '$Status', 
            `Reject_Cancel_Reason` = " . (is_null($Reject_Cancel_Reason) ? "NULL" : "'$Reject_Cancel_Reason'") . "
        WHERE `Order_Id` = '$Order_Id';
        ";

    if (mysqli_query($conn, $updateQuery)) {
        $myObj = new \stdClass();
        $myObj->success = 'true';
        echo json_encode($myObj);
        exit;
    } else {
        $myObj = new \stdClass();
        $myObj->success = 'false';
        echo json_encode($myObj);
        exit;
    }

} else {
    // Order_Id not found
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'no_order_data';
    echo json_encode($myObj);
    exit;
}
?>
