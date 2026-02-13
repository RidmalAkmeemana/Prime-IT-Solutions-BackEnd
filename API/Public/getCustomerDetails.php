<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require '../../API/Connection/config.php';

// Initialize the response array
$response = [
    "success" => false,
    "data" => []
];

if (isset($_POST['Customer_Email'])) {
    $customerEmail = $conn->real_escape_string($_POST['Customer_Email']); // Secure input

    // Fetch customer details (FIXED SQL ONLY)
    $sql = "SELECT * FROM tbl_customers WHERE Customer_Email = ?";

    // Use a prepared statement to execute the query securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $customerEmail);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response["success"] = true;
            $response["data"] = [
                "Customer_Id" => $row["Customer_Id"],
                "Customer_Name" => $row["Customer_Name"],
                "Customer_Address" => $row["Customer_Address"],
                "Customer_Contact" => $row["Customer_Contact"],
                "Customer_Email" => $row["Customer_Email"]
            ];
        } else {
            $response["message"] = "No product found with the given Customer_Email.";
        }
    } else {
        $response["message"] = "Error executing the query.";
    }

    $stmt->close();
} else {
    $response["message"] = "Customer_Email is required.";
}

// Return the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);

?>
