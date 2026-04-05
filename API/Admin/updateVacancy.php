<?php

require '../../API/Connection/BackEndPermission.php';

$Vacancy_Id = $_POST['Vacancy_Id'];
$Is_Active = $_POST['Is_Active'];
$Job_Title = $_POST['Job_Title'];
$Department_Id = $_POST['Department_Id'];
$Location_Id = $_POST['Location_Id'];
$Type_Id = $_POST['Type_Id'];
$Closing_Date = $_POST['Closing_Date'];
$Job_Description = $_POST['Job_Description'];

// Validate required fields
if (empty($Job_Title) || empty($Department_Id) || empty($Location_Id) || empty($Type_Id) || empty($Closing_Date) || empty($Job_Description)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    echo json_encode($myObj);
    exit;
}

// Check if Vacancy_Id exists
$checkQuery = "SELECT * FROM `tbl_vacancies` WHERE `Vacancy_Id` = '$Vacancy_Id';";
$result = mysqli_query($conn, $checkQuery);

if ($result && mysqli_num_rows($result) > 0) {

    //Perform update
    $updateQuery = "UPDATE `tbl_vacancies` SET `Is_Active` = '$Is_Active', `Job_Title` = '$Job_Title', `Department_Id` = '$Department_Id', `Location_Id` = '$Location_Id', `Type_Id` = '$Type_Id', `Created_Date` = NOW(), `Closing_Date` = '$Closing_Date', `Job_Description` = '$Job_Description' WHERE `tbl_vacancies`.`Vacancy_Id` = '$Vacancy_Id';";

    if (mysqli_query($conn, $updateQuery)) {
        $myObj = new \stdClass();
        $myObj->success = 'true';
        echo json_encode($myObj);
        exit;
    } else {
        $myObj = new \stdClass();
        $myObj->success = 'false';
        echo json_encode($myObj);
        exit;
    }

} else {
    // Vacancy_Id not found
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'no_vacancy_data';
    echo json_encode($myObj);
    exit;
}
?>
