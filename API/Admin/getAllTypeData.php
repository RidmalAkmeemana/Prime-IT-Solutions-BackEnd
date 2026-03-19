<?php

require '../../API/Connection/BackEndPermission.php';

$sql = "SELECT 
        t.Id, 
        t.Job_Type
    FROM 
        tbl_types t
    ORDER BY 
        t.Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Id" => $row["Id"],
            "Job_Type" => $row["Job_Type"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>