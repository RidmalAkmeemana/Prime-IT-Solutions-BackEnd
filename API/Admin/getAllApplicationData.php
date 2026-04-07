<?php

require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

$sql = "SELECT
                a.Id,
                a.Application_Id,
                a.Vacancy_Id,
                a.Applicant_Id,
                ap.Applicant_Name,
                v.Job_Title,
                v.Type_Id,
                j.Job_Type,
                ap.Applicant_Address,
                ap.Applicant_Contact,
                ap.Applicant_Email,
                ap.Applicant_CV,
                a.Status
            FROM tbl_applications a
            INNER JOIN tbl_vacancies v 
                ON a.Vacancy_Id = v.Vacancy_Id
            INNER JOIN tbl_types j 
                ON v.Type_Id = j.Id
            INNER JOIN tbl_applicants ap 
                ON a.Applicant_Id = ap.Applicant_Id ORDER BY a.Application_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        array_push($dataset, array(
            "Id" => $row["Id"],
            "Application_Id" => $row["Application_Id"],
            "Applicant_Name" => $row["Applicant_Name"],
            "Job_Title" => $row["Job_Title"],
            "Job_Type" => $row["Job_Type"],
            "Status" => $row["Status"]
        ));
    }
}

echo json_encode($dataset);
mysqli_close($conn);

?>