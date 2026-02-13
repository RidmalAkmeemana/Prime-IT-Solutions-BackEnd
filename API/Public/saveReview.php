<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
require '../Connection/config.php';

$conn->begin_transaction();

try {

    /* ===============================
       INPUTS
    ================================ */
    $customerName = $_POST['Customer_Name'] ?? '';
    $contactNo = $_POST['Customer_Contact'] ?? '';
    $email = $_POST['Customer_Email'] ?? '';
    $address = $_POST['Customer_Address'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $message = $_POST['Message'] ?? '';
    $IsApproved = '0'; 

    /* ===============================
       BASIC VALIDATION
    ================================ */
    if (empty($customerName) || empty($contactNo) || empty($email) || empty($address) || empty($message)) 
    {
        throw new Exception('Missing required fields');
    }

    /* ===============================
       CUSTOMER CHECK BY EMAIL
    ================================ */
    $stmt = $conn->prepare(
        "SELECT Customer_Id FROM tbl_customers WHERE Customer_Email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        // Existing customer
        $row = $result->fetch_assoc();
        $customerId = $row['Customer_Id'];

        // Check duplicate contact for OTHER customers
        $dup = $conn->prepare(
            "SELECT 1 FROM tbl_customers
             WHERE Customer_Contact = ?
             AND Customer_Id != ?"
        );
        $dup->bind_param("ss", $contactNo, $customerId);
        $dup->execute();
        if ($dup->get_result()->num_rows > 0) {
            throw new Exception('Contact No Already Taken');
        }

        $upd = $conn->prepare(
            "UPDATE tbl_customers
             SET Customer_Name = ?, Customer_Contact = ?, Customer_Address = ?
             WHERE Customer_Id = ?"
        );
        $upd->bind_param("ssss", $customerName, $contactNo, $address, $customerId);
        $upd->execute();

    } else {

        // New customer – generate ID
        $res = $conn->query("SELECT MAX(Customer_Id) AS max_id FROM tbl_customers");
        $row = $res->fetch_assoc();

        if (!$row['max_id']) {
            $customerId = 'CUS0001';
        } else {
            $num = intval(substr($row['max_id'], 3)) + 1;
            $customerId = 'CUS' . str_pad($num, 4, '0', STR_PAD_LEFT);
        }

        // Check duplicate contact
        $dup = $conn->prepare(
            "SELECT 1 FROM tbl_customers WHERE Customer_Contact = ?"
        );
        $dup->bind_param("s", $contactNo);
        $dup->execute();
        if ($dup->get_result()->num_rows > 0) {
            throw new Exception('Contact No Already Taken');
        }

        $ins = $conn->prepare(
            "INSERT INTO tbl_customers
            (Customer_Id, Customer_Name, Customer_Contact, Customer_Email, Customer_Address)
            VALUES (?, ?, ?, ?, ?)"
        );
        $ins->bind_param(
            "sssss",
            $customerId,
            $customerName,
            $contactNo,
            $email,
            $address
        );
        $ins->execute();
    }

    /* ===============================
       INSERT REVIEW (FIXED)
    ================================ */
    $rew = $conn->prepare(
        "INSERT INTO tbl_reviews
        (Customer_Id, Star_Rating, Message, Is_Approved, Created_Date)
        VALUES (?, ?, ?, ?, NOW())"
    );
    $rew->bind_param(
        "ssss",
        $customerId,
        $rating,
        $message,
        $IsApproved
    );
    $rew->execute();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Review submitted successfully. Pending approval.',
        'Customer_Name' => $customerName,
        'Customer_Email' => $email,
        'Rating' => $rating
    ]);

} catch (Exception $e) {

    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
