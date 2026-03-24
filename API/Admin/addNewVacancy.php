<?php

require '../../API/Connection/BackEndPermission.php';

$Job_Title = $_POST['Job_Title'];
$Department_Id = $_POST['Department_Id'];
$Location_Id = $_POST['Location_Id'];
$Type_Id = $_POST['Type_Id'];
$Closing_Date = $_POST['Closing_Date'];
$Job_Description = $_POST['Job_Description'];
$Is_Active = 1;

if (empty($Job_Title) || empty($Department_Id) || empty($Location_Id) || empty($Type_Id) || empty($Closing_Date) || empty($Job_Description)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} else {
        // Get the maximum Vacancy_Id & Customer_Contact in the database
        $maxVacIDQuery = "SELECT MAX(Vacancy_Id) AS max_vacancy_id FROM tbl_vacancies";
        $maxVacIDResult = mysqli_query($conn, $maxVacIDQuery);
        $maxVacIDRow = mysqli_fetch_assoc($maxVacIDResult);
        $maxVacID = $maxVacIDRow['max_vacancy_id'];

        // If there are no existing customers, start with CUS0001
        if (!$maxVacID) {
            $newVacancyId = 'JOB0001';
        } else {
            // Extract the numeric part of the Vacancy_Id and increment it
            $maxVacNum = intval(substr($maxVacID, 3));
            $newVacNum = str_pad($maxVacNum + 1, 4, '0', STR_PAD_LEFT);
            $newVacancyId = 'JOB' . $newVacNum;
        }

        // Perform the insertion
        $sql = "INSERT INTO `tbl_vacancies` (`Vacancy_Id`, `Job_Title`, `Department_Id`, `Job_Description`, `Location_Id`, `Type_Id`, `Is_Active`, `Created_Date`, `Closing_Date`)
                VALUES ('$newVacancyId', '$Job_Title', $Department_Id, '$Job_Description', '$Location_Id', '$Type_Id', '$Is_Active', NOW(), '$Closing_Date');";

        if (mysqli_query($conn, $sql)) {
            $myObj = new \stdClass();
            $myObj->success = 'true';
            $myJSON = json_encode($myObj);
            echo $myJSON;
        } else {
            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myObj->error = mysqli_error($conn);
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    }
?>
