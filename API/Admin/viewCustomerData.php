<?php

require '../../API/Connection/BackEndPermission.php';

$Customer_Id = $_REQUEST["Customer_Id"];

// Fetch customer data
$sqlCustomer = "SELECT * FROM tbl_customers WHERE `Customer_Id` = '$Customer_Id'";
$resultCustomer = $conn->query($sqlCustomer);

$customerData = array();

if ($resultCustomer->num_rows > 0) {
    $rowCustomer = $resultCustomer->fetch_assoc();

    // Construct Customer data
    $customerData = array(
        'Customer_Id' => $rowCustomer["Customer_Id"],
        'Customer_Name' => $rowCustomer["Customer_Name"],
        'Customer_Address' => $rowCustomer["Customer_Address"],
        'Customer_Contact' => $rowCustomer["Customer_Contact"],
        'Customer_Email' => $rowCustomer["Customer_Email"]
    );
}

// Combine Customer and invoice data into a single response object
$response = array(
    'customerData' => $customerData
);

// Encode response object as JSON and output it
echo json_encode($response);

?>
