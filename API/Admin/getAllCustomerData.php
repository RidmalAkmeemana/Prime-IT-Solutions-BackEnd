<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
            Customer_Id, 
            Customer_Name, 
            Customer_Address, 
            Customer_Contact, 
            Customer_Email 
        FROM tbl_customers
        ORDER BY Customer_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $dataset[] = array(
            "Customer_Id" => $row["Customer_Id"],
            "Customer_Name" => $row["Customer_Name"],
            "Customer_Address" => $row["Customer_Address"],
            "Customer_Contact" => $row["Customer_Contact"],
            "Customer_Email" => $row["Customer_Email"]
        );
    }
}

echo json_encode($dataset);
$conn->close();

?>