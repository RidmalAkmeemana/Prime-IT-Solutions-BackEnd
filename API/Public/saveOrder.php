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
    $packageId = $_POST['Package_Id'] ?? '';
    $eventLocation = $_POST['Event_Location'] ?? '';
    $eventDateTime = $_POST['Event_DateTime'] ?? '';
    $status = 'Pending';       
    $addonsJson = $_POST['addons'] ?? '[]';
    $addons = json_decode($addonsJson, true);

    /* ===============================
       BASIC VALIDATION
    ================================ */
    if (empty($customerName) || empty($contactNo) || empty($email) || empty($address) || empty($packageId) || empty($eventLocation) || empty($eventDateTime)) 
    {
        throw new Exception('Missing required fields');
    }

    /* ===============================
       CHECK PACKAGE EXISTS (FK FIX)
    ================================ */
    $pkgStmt = $conn->prepare(
        "SELECT Package_Name, Package_Id, Price FROM tbl_package WHERE Package_Id = ?"
    );
    $pkgStmt->bind_param("s", $packageId);
    $pkgStmt->execute();
    $pkgRes = $pkgStmt->get_result();

    if ($pkgRes->num_rows === 0) {
        throw new Exception('Invalid Package selected');
    }

    $pkgRow = $pkgRes->fetch_assoc();
    $packageName = $pkgRow['Package_Name'];
    $packagePrice = $pkgRow['Price'];

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
       ORDER ID GENERATION
    ================================ */
    $res = $conn->query("SELECT MAX(Order_Id) AS max_id FROM tbl_orders");
    $row = $res->fetch_assoc();

    if (!$row['max_id']) {
        $orderId = 'ORD0001';
    } else {
        $num = intval(substr($row['max_id'], 3)) + 1;
        $orderId = 'ORD' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    /* ===============================
       INSERT ORDER (✔ STRING FK)
    ================================ */
    $ord = $conn->prepare(
        "INSERT INTO tbl_orders
        (Order_Id, Customer_Id, Package_Id, Event_Location, Event_DateTime, Package_Price, Status, Order_Date)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
    );
    $ord->bind_param(
        "sssssds",
        $orderId,
        $customerId,
        $packageId,
        $eventLocation,
        $eventDateTime,
        $packagePrice,
        $status
    );
    $ord->execute();

    /* ===============================
       INSERT ADDONS
    ================================ */
    if (!empty($addons)) {
        $addonStmt = $conn->prepare(
            "INSERT INTO tbl_order_addons (Order_Id, Addon_Id, Addon_Price)
             VALUES (?, ?, ?)"
        );
        foreach ($addons as $addon) {
            $addonId = $addon['Addon_Id'];
            $addonPrice = $addon['Addon_Price'];
            $addonStmt->bind_param("sid", $orderId, $addonId, $addonPrice);
            $addonStmt->execute();
        }
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'Order_Id' => $orderId,
        'Customer_Name' => $customerName,
        'Customer_Email' => $email,
        'Package_Name' => $packageName,
        'Event_Location' => $eventLocation,
        'Event_DateTime' => $eventDateTime,
        'Package_Price' => $packagePrice,
        'Status' => $status,
        'Addons' => $addons
    ]);

} catch (Exception $e) {

    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
