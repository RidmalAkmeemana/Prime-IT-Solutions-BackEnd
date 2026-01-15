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

// Fetch orders for the Customer
$sqlOrders = "SELECT
        o.Id,
        o.Order_Id,
        o.Customer_Id,
        o.Package_Id,
        p.Package_Name,
        o.Event_DateTime,
        o.Event_Location,
        o.Status,
        o.Order_Date
    FROM tbl_orders o
    LEFT JOIN tbl_package p 
        ON o.Package_Id = p.Package_Id
    WHERE o.Customer_Id = '$Customer_Id'
    ORDER BY o.Order_Id DESC";
                
$resultOrders = $conn->query($sqlOrders);

// Check if the query executed successfully
if (!$resultOrders) {
    // If the query fails, output the error message
    die("Error in SQL query: " . $conn->error);
}

$orders = array();

if ($resultOrders->num_rows > 0) {
    while ($rowOrders = $resultOrders->fetch_assoc()) {
        // Construct invoices data
        $ordersData = array(
            'Id' => $rowOrders['Id'],
            'Order_Id' => $rowOrders['Order_Id'],
            'Customer_Id' => $rowOrders['Customer_Id'],
            'Package_Id' => $rowOrders['Package_Id'],
            'Package_Name' => $rowOrders['Package_Name'],
            'Event_Location' => $rowOrders['Event_Location'],
            'Event_DateTime' => $rowOrders['Event_DateTime'],
            'Status' => $rowOrders['Status'],
            'Order_Date' => $rowOrders['Order_Date'],
        );
        array_push($orders, $ordersData);
    }
}

// Combine Customer and invoice data into a single response object
$response = array(
    'customerData' => $customerData,
    'orders' => $orders
);

// Encode response object as JSON and output it
echo json_encode($response);

?>
