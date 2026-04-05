<?php
require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

// Secure input
$Application_Id = mysqli_real_escape_string($conn, $_POST['Application_Id']);

$query = "SELECT
            a.Application_Id,
            a.Vacancy_Id,
            v.Job_Title,
            l.Location_Name,
            t.Job_Type,
            a.Applicant_Id,
            a.Status,
            ap.Applicant_Name,
            ap.Applicant_Address,
            ap.Applicant_Contact,
            ap.Applicant_Email,
            ap.Applicant_CV
          FROM tbl_applications a 
          JOIN tbl_vacancies v ON v.Vacancy_Id = a.Vacancy_Id
          JOIN tbl_locations l ON l.Id = v.Location_Id
          JOIN tbl_types t ON t.Id = v.Type_Id
          JOIN tbl_applicants ap ON ap.Applicant_Id = a.Applicant_Id
          WHERE a.Application_Id = '$Application_Id'";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode([
        "success" => "false",
        "error" => mysqli_error($conn)
    ]);
    exit;
}

if ($row = mysqli_fetch_assoc($result)) {

    $filePath = $row["Applicant_CV"];

    $response = [
        "success" => "true",
        "Application_Id" => $row['Application_Id'],
        "Vacancy_Id" => $row['Vacancy_Id'],
        "Job_Title" => $row['Job_Title'],
        "Job_Location" => $row['Location_Name'],
        "Job_Type" => $row['Job_Type'],
        "Applicant_Id" => $row['Applicant_Id'],
        "Applicant_Name" => $row['Applicant_Name'],
        "Applicant_Address" => $row['Applicant_Address'],
        "Applicant_Contact" => $row['Applicant_Contact'],
        "Applicant_Email" => $row['Applicant_Email'],
        "Status" => $row['Status'],
        "cvPdfUrl" => $base_url . $filePath
    ];

} else {
    $response = [
        "success" => "false",
        "error" => "no_data_found"
    ];
}

echo json_encode($response);
?>