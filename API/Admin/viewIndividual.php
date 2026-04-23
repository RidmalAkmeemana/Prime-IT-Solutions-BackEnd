<?php
require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

// Secure input
$Individuals_Id = mysqli_real_escape_string($conn, $_POST['Individuals_Id']);

$query = "SELECT
            i.Individuals_Id,
            i.Job_Title,
            i.Applicant_Id,
            i.Status,
            ap.Applicant_Name,
            ap.Applicant_Address,
            ap.Applicant_Contact,
            ap.Applicant_Email,
            ap.Applicant_CV
          FROM tbl_individuals i 
          JOIN tbl_applicants ap ON ap.Applicant_Id = i.Applicant_Id
          WHERE i.Individuals_Id = '$Individuals_Id'";

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
        "Individuals_Id" => $row['Individuals_Id'],
        "Job_Title" => $row['Job_Title'],
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