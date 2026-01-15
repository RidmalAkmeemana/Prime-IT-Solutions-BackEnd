<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
    o.Id,
    o.Order_Id,
    o.Customer_Id,
    c.Customer_Name, -- Fetch Customer Name
    o.Package_Id,
    p.Package_Name,  -- Fetch Pacjage Name
    o.Event_Location,
    o.Event_DateTime,
    o.Status,
    o.Order_Date
    FROM tbl_orders o
    JOIN tbl_customers c ON o.Customer_Id = c.Customer_Id
    JOIN tbl_package p ON o.Package_Id = p.Package_Id 
    ORDER BY o.Order_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Order_Id" => $row["Order_Id"],
            "Customer_Id" => $row["Customer_Id"],
            "Customer_Name" => $row["Customer_Name"],
            "Package_Id" => $row["Package_Id"],
            "Package_Name" => $row["Package_Name"],
            "Event_Location" => $row["Event_Location"],
            "Event_DateTime" => $row["Event_DateTime"],
            "Status" => $row["Status"],
            "Order_Date" => $row["Order_Date"],
        ));
    }
}

echo json_encode($dataset); // No JSON_NUMERIC_CHECK to avoid conversion of numeric strings
mysqli_close($conn);

?>