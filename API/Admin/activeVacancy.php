<?php

require '../../API/Connection/BackEndPermission.php';

$Vacancy_Id = $_POST['Vacancy_Id'];
$Is_Active = $_POST['Is_Active'];

if (!isset($Vacancy_Id) || !isset($Is_Active)) {
    $myObj = new \stdClass();
    $myObj->success = 'false';
    $myObj->error = 'empty';
    $myJSON = json_encode($myObj);
    echo $myJSON;
} 
else {
    
    // Check if Vacancy_Id exists in the database
    $checkQuery = "SELECT * FROM `tbl_vacancies` WHERE `tbl_vacancies`.`Vacancy_Id` = '$Vacancy_Id';";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // If Vacancy_Id exists, perform the update
        $updateQuery = "UPDATE `tbl_vacancies` SET `Is_Active` = '$Is_Active' WHERE `tbl_vacancies`.`Vacancy_Id` = '$Vacancy_Id';";
        if (mysqli_query($conn, $updateQuery)) {
            $myObj = new \stdClass();
            $myObj->success = 'true';
            $myJSON = json_encode($myObj);
            echo $myJSON;
        } else {
            $myObj = new \stdClass();
            $myObj->success = 'false';
            $myJSON = json_encode($myObj);
            echo $myJSON;
        }
    } else {
        // If Id doesn't exist, send appropriate response
        $myObj = new \stdClass();
        $myObj->success = 'false';
        $myObj->error = 'no_vacancy_data';
        $myJSON = json_encode($myObj);
        echo $myJSON;
    }
}
?>