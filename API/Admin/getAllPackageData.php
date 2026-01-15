<?php

require '../../API/Connection/BackEndPermission.php';

// Fetch products with Qty > 0 and Inventort_Updated = 'True'
$sql = "SELECT 
        p.Package_Id, 
        p.Package_Name,
        p.Package_Description,
        p.Price
    FROM 
        tbl_package p
    ORDER BY 
        p.Package_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Package_Id" => $row["Package_Id"],
            "Package_Name" => $row["Package_Name"],
            "Package_Description" => $row["Package_Description"],
            "Price" => $row["Price"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>