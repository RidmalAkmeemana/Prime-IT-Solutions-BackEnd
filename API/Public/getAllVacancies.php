<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require '../../API/Connection/config.php';

$sql = "SELECT 
            v.Vacancy_Id,
            v.Job_Title,
            d.Department_Name,
            v.Job_Description,
            l.Location_Name,
            t.Job_Type,
            v.Closing_Date
        FROM tbl_vacancies v
        LEFT JOIN tbl_departments d ON v.Department_Id = d.Id
        LEFT JOIN tbl_locations l ON v.Location_Id = l.Id
        LEFT JOIN tbl_types t ON v.Type_Id = t.Id
        LEFT JOIN tbl_applications a ON v.Vacancy_Id = a.Vacancy_Id
        WHERE v.Is_Active = '1'
        ORDER BY v.Vacancy_Id ASC";

$result = $conn->query($sql);

$dataset = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($dataset, array(
            "Vacancy_Id" => $row["Vacancy_Id"],
            "Job_Title" => $row["Job_Title"],
            "Department_Name" => $row["Department_Name"],
            "Job_Description" => $row["Job_Description"],
            "Location_Name" => $row["Location_Name"],
            "Job_Type" => $row["Job_Type"],
            "Closing_Date" => $row["Closing_Date"]
        ));
    }
}

echo json_encode($dataset); // No JSON_NUMERIC_CHECK to avoid conversion of numeric strings
mysqli_close($conn);

?>