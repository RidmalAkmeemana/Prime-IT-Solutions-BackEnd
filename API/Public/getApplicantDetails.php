<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require '../../API/Connection/config.php';

// Initialize the response array
$response = [
    "success" => false,
    "data" => []
];

if (isset($_POST['Applicant_Email'])) {
    $customerEmail = $conn->real_escape_string($_POST['Applicant_Email']); // Secure input

    // Fetch customer details (FIXED SQL ONLY)
    $sql = "SELECT * FROM tbl_applicants WHERE Applicant_Email = ?";

    // Use a prepared statement to execute the query securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $customerEmail);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response["success"] = true;
            $response["data"] = [
                "Applicant_Id" => $row["Applicant_Id"],
                "Applicant_Name" => $row["Applicant_Name"],
                "Applicant_Address" => $row["Applicant_Address"],
                "Applicant_Contact" => $row["Applicant_Contact"],
                "Applicant_Email" => $row["Applicant_Email"]
            ];
        } else {
            $response["message"] = "No applicant found with the given Applicant_Email.";
        }
    } else {
        $response["message"] = "Error executing the query.";
    }

    $stmt->close();
} else {
    $response["message"] = "Applicant_Email is required.";
}

// Return the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);

?>
