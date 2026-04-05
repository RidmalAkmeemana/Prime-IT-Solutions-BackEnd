<?php

require '../../API/Connection/BackEndPermission.php';
include '../Connection/uploadurl.php';

$Vacancy_Id = $_REQUEST["Vacancy_Id"];

$sqlVacancy = "SELECT 
            v.Id,
            v.Vacancy_Id,
            v.Job_Title,
            v.Department_Id,
            d.Department_Name,
            v.Job_Description,
            v.Location_Id,
            l.Location_Name,
            v.Type_Id,
            j.Job_Type,
            v.Is_Active,
            v.Created_Date,
            v.Closing_Date
        FROM tbl_vacancies v
        JOIN tbl_departments d ON v.Department_Id = d.Id
        JOIN tbl_locations l ON v.Location_Id = l.Id
        JOIN tbl_types j ON v.Type_Id = j.Id
        WHERE v.Vacancy_Id = '$Vacancy_Id'
        LIMIT 1";

$resultVacancy = $conn->query($sqlVacancy);

$vacancyData = array();

if ($resultVacancy && $resultVacancy->num_rows > 0) {

    $rowVacancy = $resultVacancy->fetch_assoc();

    $vacancyData = array(
        'Vacancy_Id' => $rowVacancy['Vacancy_Id'],
        'Job_Title' => $rowVacancy['Job_Title'],
        'Department_Name' => $rowVacancy['Department_Name'],
        'Job_Description' => $rowVacancy['Job_Description'],
        'Location_Name' => $rowVacancy['Location_Name'],
        'Job_Type' => $rowVacancy['Job_Type'],
        'Is_Active' => $rowVacancy['Is_Active'],
        'Created_Date' => $rowVacancy['Created_Date'],
        'Closing_Date' => $rowVacancy['Closing_Date']
    );
}

$sqlApplications = "SELECT
                a.Id,
                a.Application_Id,
                a.Vacancy_Id,
                a.Applicant_Id,
                ap.Applicant_Name,
                ap.Applicant_Address,
                ap.Applicant_Contact,
                ap.Applicant_Email,
                ap.Applicant_CV,
                a.status
            FROM tbl_applications a
            INNER JOIN tbl_vacancies v 
                ON a.Vacancy_Id = v.Vacancy_Id
            INNER JOIN tbl_applicants ap 
                ON a.Applicant_Id = ap.Applicant_Id
            WHERE a.Vacancy_Id = '$Vacancy_Id' ORDER BY a.Application_Id ASC";

$resultApplications = $conn->query($sqlApplications);

$applications = array();

if ($resultApplications && $resultApplications->num_rows > 0) {
    while ($rowApplications = $resultApplications->fetch_assoc()) {

        $filePath = $rowApplications["Applicant_CV"];

        $applications[] = array(
            'Application_Id'    => $rowApplications['Application_Id'],
            'Applicant_Id'  => $rowApplications['Applicant_Id'],
            'Applicant_Name'  => $rowApplications['Applicant_Name'],
            'Applicant_Address'  => $rowApplications['Applicant_Address'],
            'Applicant_Contact'  => $rowApplications['Applicant_Contact'],
            'Applicant_Email'  => $rowApplications['Applicant_Email'],
            'Applicant_CV'  => $base_url . $filePath,
            'status'  => $rowApplications['status'],
        );
    }
}

$response = array(
    'success' => true,
    'vacancyData' => $vacancyData,
    'applications' => $applications
);

echo json_encode($response);
