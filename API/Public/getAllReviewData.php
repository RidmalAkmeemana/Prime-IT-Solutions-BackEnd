<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require '../../API/Connection/config.php';

$sql = "SELECT 
        r.Id, 
        r.Customer_Id,
        c.Customer_Name,
        c.Customer_Email,
        r.Star_Rating,
        r.Message,
        r.Is_Approved,
        r.Created_Date
    FROM 
        tbl_reviews r
        JOIN tbl_customers c ON r.Customer_Id = c.Customer_Id
    WHERE 
        r.Is_Approved = '1'
    ORDER BY 
        r.Id DESC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Customer_Id" => $row["Customer_Id"],
            "Customer_Name" => $row["Customer_Name"],
            "Customer_Email" => $row["Customer_Email"],
            "Star_Rating" => $row["Star_Rating"],
            "Message" => $row["Message"],
            "Is_Approved" => $row["Is_Approved"],
            "Created_Date" => $row["Created_Date"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>