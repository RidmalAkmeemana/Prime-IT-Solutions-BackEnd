<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
        d.Id, 
        d.Department_Name,
        d.Department_description
    FROM 
        tbl_departments d
    ORDER BY 
        d.Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Department_Name" => $row["Department_Name"],
            "Department_description" => $row["Department_description"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>