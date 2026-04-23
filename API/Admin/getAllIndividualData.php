<?php

require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

$sql = "SELECT
                i.Id,
                i.Individuals_Id,
                i.Job_Title,
                i.Applicant_Id,
                ap.Applicant_Name,
                ap.Applicant_Address,
                ap.Applicant_Contact,
                ap.Applicant_Email,
                ap.Applicant_CV,
                i.Status
            FROM tbl_individuals i
            INNER JOIN tbl_applicants ap 
                ON i.Applicant_Id = ap.Applicant_Id ORDER BY i.Individuals_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        array_push($dataset, array(
            "Id" => $row["Id"],
            "Individuals_Id" => $row["Individuals_Id"],
            "Applicant_Name" => $row["Applicant_Name"],
            "Job_Title" => $row["Job_Title"],
            "Status" => $row["Status"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>