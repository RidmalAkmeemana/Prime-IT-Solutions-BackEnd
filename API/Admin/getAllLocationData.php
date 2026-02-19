<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
        l.Id, 
        l.Postal_Code,
        l.Location_Name
    FROM 
        tbl_locations l
    ORDER BY 
        l.Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Postal_Code" => $row["Postal_Code"],
            "Location_Name" => $row["Location_Name"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>