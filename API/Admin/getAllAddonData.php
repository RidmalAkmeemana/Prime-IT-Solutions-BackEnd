<?php

require '../../API/Connection/BackEndPermission.php';

// Fetch products with Qty > 0 and Inventort_Updated = 'True'
$sql = "SELECT 
        a.Id, 
        a.Addon_Name,
        a.Addon_description,
        a.Addon_Price
    FROM 
        tbl_addon a
    ORDER BY 
        a.Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Addon_Name" => $row["Addon_Name"],
            "Addon_description" => $row["Addon_description"],
            "Addon_Price" => $row["Addon_Price"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>