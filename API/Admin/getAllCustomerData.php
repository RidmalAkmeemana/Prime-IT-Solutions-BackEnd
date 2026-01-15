<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT tbl_customers.*, 
           COUNT(tbl_orders.Order_Id) AS order_count 
    FROM tbl_customers
    LEFT JOIN tbl_orders ON tbl_customers.Customer_Id = tbl_orders.Customer_Id 
    GROUP BY tbl_customers.Customer_Id, tbl_customers.Customer_Name, tbl_customers.Customer_Address, tbl_customers.Customer_Contact, tbl_customers.Customer_Email 
    ORDER BY tbl_customers.Customer_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        array_push($dataset, array(
            "Customer_Id" => $row["Customer_Id"],
            "Customer_Name" => $row["Customer_Name"],
            "Customer_Address" => $row["Customer_Address"],
            "Customer_Contact" => $row["Customer_Contact"],
            "Customer_Email" => $row["Customer_Email"],
            "order_count" => number_format($row["order_count"])
        ));
    }
}

echo json_encode($dataset); // No JSON_NUMERIC_CHECK to avoid conversion of numeric strings
mysqli_close($conn);

?>