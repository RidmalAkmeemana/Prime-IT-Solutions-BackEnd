<?php

require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

$sql = "SELECT * FROM  tbl_applicants ORDER BY Applicant_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $cvPath = $row["Applicant_CV"];
        $cv_url = $base_url . $cvPath;

        array_push($dataset, array(
            "Id" => $row["Id"],
            "Applicant_Id" => $row["Applicant_Id"],
            "Applicant_Name" => $row["Applicant_Name"],
            "Applicant_Address" => $row["Applicant_Address"],
            "Applicant_Contact" => $row["Applicant_Contact"],
            "Applicant_Email" => $row["Applicant_Email"],
            "Applicant_CV" => $cv_url
            

        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>