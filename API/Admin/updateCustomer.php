<?php

require '../../API/Connection/BackEndPermission.php';

$Customer_Id      = $_POST['Customer_Id'];
$Customer_Name    = $_POST['Customer_Name'];
$Customer_Contact = $_POST['Customer_Contact'];
$Customer_Email   = $_POST['Customer_Email'];
$Customer_Address = $_POST['Customer_Address'];

// Validate required fields
if (empty($Customer_Id) || empty($Customer_Name) || empty($Customer_Contact) || empty($Customer_Email) || empty($Customer_Address)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit;
}

// Check if Customer_Id exists
$checkQuery = "SELECT * FROM `tbl_customers` WHERE `Customer_Id` = '$Customer_Id';";
$result = mysqli_query($conn, $checkQuery);

if ($result && mysqli_num_rows($result) > 0) {

    //Check duplicate Email or Contact (EXCEPT current customer)
    $duplicateQuery = "
        SELECT * 
        FROM `tbl_customers` 
        WHERE (`Customer_Email` = '$Customer_Email'
            OR `Customer_Contact` = '$Customer_Contact')
          AND `Customer_Id` != '$Customer_Id'
    ";
    $duplicateResult = mysqli_query($conn, $duplicateQuery);

    if (mysqli_num_rows($duplicateResult) > 0) {
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'duplicate';
        echo json_encode($myObj);
        exit;
    }

    //Handle NULL values
    $Customer_Address = $Customer_Address === 'NULL' ? 'NULL' : "'$Customer_Address'";
    $Customer_Email   = $Customer_Email === 'NULL' ? 'NULL' : "'$Customer_Email'";

    //Perform update
    $updateQuery = "
        UPDATE `tbl_customers`
        SET 
            `Customer_Name` = '$Customer_Name', 
            `Customer_Address` = $Customer_Address, 
            `Customer_Contact` = '$Customer_Contact', 
            `Customer_Email` = $Customer_Email
        WHERE `Customer_Id` = '$Customer_Id';
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
    // Customer_Id not found
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'no_customer_data';
    echo json_encode($myObj);
    exit;
}
?>
