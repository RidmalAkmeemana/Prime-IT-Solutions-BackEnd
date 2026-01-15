<?php

header("Content-Type: application/json; charset=UTF-8");
require '../../API/Connection/config.php';

$Package_Id = $_REQUEST["Package_Id"];

// Fetch package data
$sqlPackage = "SELECT * FROM tbl_package WHERE `Package_Id` = '$Package_Id'";
$resultPackage = $conn->query($sqlPackage);

$packageData = array();

if ($resultPackage->num_rows > 0) {
    $rowPackage = $resultPackage->fetch_assoc();

    // Construct Customer data
    $packageData = array(
        'Package_Id' => $rowPackage["Package_Id"],
        'Package_Name' => $rowPackage["Package_Name"],
        'Package_Description' => $rowPackage["Package_Description"],
        'Price' => $rowPackage["Price"]
    );
}

// Fetch addons
$sqlAddons = "SELECT * FROM tbl_addon ORDER BY Id";
                
$resultAddons = $conn->query($sqlAddons);

// Check if the query executed successfully
if (!$resultAddons) {
    // If the query fails, output the error message
    die("Error in SQL query: " . $conn->error);
}

$addons = array();

if ($resultAddons->num_rows > 0) {
    while ($rowAddons = $resultAddons->fetch_assoc()) {
        // Construct addons data
        $addonsData = array(
            'Id' => $rowAddons['Id'],
            'Addon_Name' => $rowAddons['Addon_Name'],
            'Addon_description' => $rowAddons['Addon_description'],
            'Addon_Price' => $rowAddons['Addon_Price']
        );
        array_push($addons, $addonsData);
    }
}

// Combine Customer and invoice data into a single response object
$response = array(
    'packageData' => $packageData,
    'addons' => $addons
);

// Encode response object as JSON and output it
echo json_encode($response);

?>
