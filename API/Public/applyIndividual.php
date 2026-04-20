<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require '../Connection/config.php';
include '../../API/Connection/uploadurl.php';

$conn->begin_transaction();

try {

    /* ===============================
       INPUTS
    ================================ */
    $jobTitle = $_POST['Job_Title'] ?? '';
    $applicantName = $_POST['Applicant_Name'] ?? '';
    $contactNo = $_POST['Applicant_Contact'] ?? '';
    $email = $_POST['Applicant_Email'] ?? '';
    $address = $_POST['Applicant_Address'] ?? '';
    $status = 'Pending';

    /* ===============================
       BASIC VALIDATION
    ================================ */
    if (empty($applicantName) || empty($contactNo) || empty($email) || empty($address) || empty($jobTitle)) {
        throw new Exception('Missing required fields');
    }

    /* ===============================
       APPLICANT CHECK BY EMAIL
    ================================ */
    $stmt = $conn->prepare(
        "SELECT Applicant_Id FROM tbl_applicants WHERE Applicant_Email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $isNewApplicant = ($result->num_rows === 0);

    if (!$isNewApplicant) {

        // Existing applicant
        $row = $result->fetch_assoc();
        $applicantId = $row['Applicant_Id'];

        // Check duplicate contact
        $dup = $conn->prepare(
            "SELECT 1 FROM tbl_applicants
             WHERE Applicant_Contact = ?
             AND Applicant_Id != ?"
        );
        $dup->bind_param("ss", $contactNo, $applicantId);
        $dup->execute();
        if ($dup->get_result()->num_rows > 0) {
            throw new Exception('Contact No Already Taken');
        }

        $upd = $conn->prepare(
            "UPDATE tbl_applicants
             SET Applicant_Name = ?, Applicant_Contact = ?, Applicant_Address = ?
             WHERE Applicant_Id = ?"
        );
        $upd->bind_param("ssss", $applicantName, $contactNo, $address, $applicantId);
        $upd->execute();

    } else {

        // New applicant – generate ID
        $res = $conn->query("SELECT MAX(Applicant_Id) AS max_id FROM tbl_applicants");
        $row = $res->fetch_assoc();

        if (!$row['max_id']) {
            $applicantId = 'APP0001';
        } else {
            $num = intval(substr($row['max_id'], 3)) + 1;
            $applicantId = 'APP' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        // Check duplicate contact
        $dup = $conn->prepare(
            "SELECT 1 FROM tbl_applicants WHERE Applicant_Contact = ?"
        );
        $dup->bind_param("s", $contactNo);
        $dup->execute();
        if ($dup->get_result()->num_rows > 0) {
            throw new Exception('Contact No Already Taken');
        }

        $ins = $conn->prepare(
            "INSERT INTO tbl_applicants
            (Applicant_Id, Applicant_Name, Applicant_Contact, Applicant_Email, Applicant_Address)
            VALUES (?, ?, ?, ?, ?)"
        );
        $ins->bind_param(
            "sssss",
            $applicantId,
            $applicantName,
            $contactNo,
            $email,
            $address
        );
        $ins->execute();
    }

    /* ===============================
       CV UPLOAD
    ================================ */
    $cvPath = '';

    if (isset($_FILES['Applicant_CV']) && $_FILES['Applicant_CV']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['application/pdf'];

        if (in_array($_FILES['Applicant_CV']['type'], $allowedTypes)) {

            $fileExtension = pathinfo($_FILES['Applicant_CV']['name'], PATHINFO_EXTENSION);

            $uploadDir = '../../Files/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = $applicantId . '.' . $fileExtension;
            $fullPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['Applicant_CV']['tmp_name'], $fullPath)) {
                $cvPath = 'Files/' . $newFileName . '?v=' . time();
            } else {
                throw new Exception('Failed to upload CV');
            }

        } else {
            throw new Exception('Only PDF files allowed');
        }

    } else {

        if ($isNewApplicant) {
            throw new Exception('CV is required for new applicants');
        }

        // Get existing CV
        $getCV = $conn->prepare("SELECT Applicant_CV FROM tbl_applicants WHERE Applicant_Id = ?");
        $getCV->bind_param("s", $applicantId);
        $getCV->execute();
        $resCV = $getCV->get_result();

        if ($resCV->num_rows > 0) {
            $rowCV = $resCV->fetch_assoc();

            if (!empty($rowCV['Applicant_CV'])) {
                $existing_cv = preg_replace('#.*/(Files/.*)$#i', '$1', $rowCV['Applicant_CV']);
                $cvPath = $existing_cv;
            } else {
                throw new Exception('CV not found. Please upload CV');
            }
        }
    }

    // Update CV path
    $cvUpdate = $conn->prepare(
        "UPDATE tbl_applicants SET Applicant_CV = ? WHERE Applicant_Id = ?"
    );
    $cvUpdate->bind_param("ss", $cvPath, $applicantId);
    $cvUpdate->execute();

    /* ===============================
       INDIVIDUAL ID GENERATION 
    ================================ */
    $res = $conn->query("SELECT MAX(Individuals_Id) AS max_id FROM tbl_individuals");
    $row = $res->fetch_assoc();

    if (!$row['max_id']) {
        $individualsId = 'IND0001';
    } else {
        $num = intval(substr($row['max_id'], 3)) + 1;
        $individualsId = 'IND' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    /* ===============================
    CHECK DUPLICATE INDIVIDUAL
    ================================ */
    $checkApp = $conn->prepare(
        "SELECT 1 FROM tbl_individuals 
        WHERE Individuals_Id = ? AND Applicant_Id = ?"
    );
    $checkApp->bind_param("ss", $individualsId, $applicantId);
    $checkApp->execute();
    $checkRes = $checkApp->get_result();

    if ($checkRes->num_rows > 0) {
        throw new Exception('You have already applied for this job');
    }

    /* ===============================
    INSERT INDIVIDUAL
    ================================ */
    $app = $conn->prepare(
        "INSERT INTO tbl_individuals
        (Individuals_Id, Job_Title, Applicant_Id, Status)
        VALUES (?, ?, ?, ?)"
    );
    $app->bind_param(
        "ssss",
        $individualsId,
        $jobTitle,
        $applicantId,
        $status
    );
    $app->execute();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'Individuals_Id' => $individualsId,
        'Job_Title' => $jobTitle,
        'Applicant_Name' => $applicantName,
        'Applicant_Address' => $address,
        'Applicant_Contact' => $contactNo,
        'Applicant_Email' => $email,
        'Status' => $status,
        'Applicant_CV' => $cvPath
    ]);

} catch (Exception $e) {

    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}