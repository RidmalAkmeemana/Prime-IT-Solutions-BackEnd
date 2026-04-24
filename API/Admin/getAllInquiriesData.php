<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
        co.Id, 
        co.Customer_Id,
        c.Customer_Name,
        c.Customer_Email,
        co.Subject,
        co.Message,
        co.Created_Date
    FROM 
        tbl_contact co
        JOIN tbl_customers c ON co.Customer_Id = c.Customer_Id
    ORDER BY 
        co.Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Customer_Id" => $row["Customer_Id"],
            "Customer_Name" => $row["Customer_Name"],
            "Customer_Email" => $row["Customer_Email"],
            "Subject" => $row["Subject"],
            "Message" => $row["Message"],
            "Created_Date" => $row["Created_Date"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>