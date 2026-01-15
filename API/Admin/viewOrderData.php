<?php

require '../../API/Connection/BackEndPermission.php';

$Order_Id = $_REQUEST["Order_Id"];

$sqlOrder = "SELECT 
            o.Id,
            o.Order_Id,
            o.Customer_Id,
            c.Customer_Name,
            c.Customer_Contact,
            c.Customer_Email,
            c.Customer_Address,
            o.Package_Id,
            p.Package_Name,
            p.Package_Description,
            p.Price,
            o.Event_Location,
            o.Event_DateTime,
            o.Status,
            o.Order_Date,
            o.Reject_Cancel_Reason
        FROM tbl_orders o
        JOIN tbl_customers c ON o.Customer_Id = c.Customer_Id
        JOIN tbl_package p ON o.Package_Id = p.Package_Id
        WHERE o.Order_Id = '$Order_Id'
        LIMIT 1";

$resultOrder = $conn->query($sqlOrder);

$orderData = array();

if ($resultOrder && $resultOrder->num_rows > 0) {

    $rowOrder = $resultOrder->fetch_assoc();

    $orderData = array(
        'Order_Id' => $rowOrder['Order_Id'],
        'Package_Name' => $rowOrder['Package_Name'],
        'Package_Description' => $rowOrder['Package_Description'],
        'Price' => $rowOrder['Price'],
        'Event_Location' => $rowOrder['Event_Location'],
        'Event_DateTime' => $rowOrder['Event_DateTime'],
        'Status' => $rowOrder['Status'],
        'Order_Date' => $rowOrder['Order_Date'],
        'Reject_Cancel_Reason' => $rowOrder['Reject_Cancel_Reason'],
        'Customer_Name' => $rowOrder['Customer_Name'],
        'Customer_Contact' => $rowOrder['Customer_Contact'],
        'Customer_Email' => $rowOrder['Customer_Email'],
        'Customer_Address' => $rowOrder['Customer_Address']
    );
}

$sqlAddons = "SELECT
                oa.Id,
                oa.Order_Id,
                oa.Addon_Id,
                a.Addon_Name,
                a.Addon_Price,
                a.Addon_description
            FROM tbl_order_addons oa
            INNER JOIN tbl_orders o 
                ON oa.Order_Id = o.Order_Id
            INNER JOIN tbl_addon a 
                ON oa.Addon_Id = a.Id
            WHERE oa.Order_Id = '$Order_Id'";

$resultAddons = $conn->query($sqlAddons);

$addons = array();

if ($resultAddons && $resultAddons->num_rows > 0) {
    while ($rowAddon = $resultAddons->fetch_assoc()) {
        $addons[] = array(
            'Addon_Id'    => $rowAddon['Addon_Id'],
            'Addon_Name'  => $rowAddon['Addon_Name'],
            'Addon_description'  => $rowAddon['Addon_description'],
            'Addon_Price' => number_format($rowAddon['Addon_Price'], 2)
        );
    }
}

$response = array(
    'success'   => true,
    'orderData' => $orderData,
    'addons'    => $addons
);

echo json_encode($response);
