<?php

require '../../API/Connection/BackEndPermission.php';

// Initialize the response array
$response = [
    "success" => false,
    "data" => []
];

if (isset($_POST['Package_Id'])) {
    $packageId = $conn->real_escape_string($_POST['Package_Id']); // Secure input

    // Fetch product details with inventory quantity
    $sql = "
        SELECT 
            p.Package_Id, 
            p.Package_Name,
            p.Package_Description,
            p.Price
        FROM 
            tbl_package p
        WHERE 
            p.Package_Id = ?
        GROUP BY
            p.Package_Id, p.Package_Name, p.Package_Description, p.Price
        LIMIT 1
    ";

    // Use a prepared statement to execute the query securely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $packageId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response["success"] = true;
            $response["data"] = [
                "Package_Id" => $row["Package_Id"],
                "Package_Name" => $row["Package_Name"],
                "Package_Description" => $row["Package_Description"],
                "Price" => $row["Price"]
            ];
        } else {
            $response["message"] = "No product found with the given Package_Id.";
        }
    } else {
        $response["message"] = "Error executing the query.";
    }

    $stmt->close();
} else {
    $response["message"] = "Package_Id is required.";
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response, JSON_NUMERIC_CHECK);

// Close the database connection
mysqli_close($conn);

?>