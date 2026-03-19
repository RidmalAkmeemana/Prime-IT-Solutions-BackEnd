<?php

require '../../API/Connection/BackEndPermission.php';

// SQL query to get the Role details and the sum of user count related to Status
$sql = "SELECT * 
    FROM tbl_vacancies
    LEFT JOIN tbl_departments ON tbl_vacancies.Department_Id = tbl_departments.Id
    LEFT JOIN tbl_locations ON tbl_vacancies.Location_Id = tbl_locations.Id
    LEFT JOIN tbl_types ON tbl_vacancies.Type_Id = tbl_types.Id
    ORDER BY tbl_vacancies.Vacancy_Id ASC";

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
            "Is_Active" => $row["Is_Active"],
            "Created_Date" => $row["Created_Date"],
            "Closing_Date" => $row["Closing_Date"]
        ));
    }
}

echo json_encode($dataset); // No JSON_NUMERIC_CHECK to avoid conversion of numeric strings
mysqli_close($conn);

?>
