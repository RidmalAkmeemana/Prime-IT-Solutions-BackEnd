<?php
// getDashboardSuperAdminData.php
require '../../API/Connection/config.php';
header('Content-Type: application/json; charset=utf-8');

session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => 'false', 'message' => 'unauthorized']);
    exit;
}

// 1) Counts (Safe Queries)
function getCount($conn, $table) {
    $q = $conn->query("SELECT COUNT(*) AS c FROM $table");
    if ($q && $row = $q->fetch_assoc()) return (int)$row['c'];
    return 0;
}

$counts = [];
$counts['Count_Customers']   = getCount($conn, "tbl_customers");
$counts['Count_Users']       = getCount($conn, "tbl_user");
$counts['Count_Roles']       = getCount($conn, "tbl_roles");
$counts['Count_Departments'] = getCount($conn, "tbl_departments");
$counts['Count_Locations']   = getCount($conn, "tbl_locations");
$counts['Count_Types']       = getCount($conn, "tbl_types");
$counts['Count_Applications']= getCount($conn, "tbl_applications");
$counts['Count_Inquiries']   = getCount($conn, "tbl_contact");

// 2) Extra Counts
// Count of Active Vacancies
$row3 = $conn->query("SELECT COUNT(*) AS cnt FROM tbl_vacancies WHERE Is_Active = 1");
$counts['Count_ActiveVacancies'] = $row3 ? (int)$row3->fetch_assoc()['cnt'] : 0;

// Count of Applicants
$row4 = $conn->query("SELECT COUNT(*) AS cnt FROM tbl_applicants");
$counts['Count_Applicants'] = $row4 ? (int)$row4->fetch_assoc()['cnt'] : 0;

// Count of Pending Applications
$row5 = $conn->query("SELECT COUNT(*) AS cnt FROM tbl_applications WHERE Status = 'Pending'");
$counts['Count_PendingApplications'] = $row5 ? (int)$row5->fetch_assoc()['cnt'] : 0;

// 3) Application Count per Status (Bar Graph)
// Status values: Pending, Sort Listed, Rejected, Interview, Hired
$applicationStatus = [];
$q = $conn->query("
    SELECT 
        Status AS status,
        COUNT(*) AS count
    FROM tbl_applications
    GROUP BY Status
    ORDER BY FIELD(Status, 'Pending', 'Sort Listed', 'Interview', 'Hired', 'Rejected')
");
if ($q) {
    while ($r = $q->fetch_assoc()) {
        $applicationStatus[] = [
            'status' => $r['status'],
            'count'  => (int)$r['count']
        ];
    }
}

// 4) Vacancies per Department (Pie Chart)
$vacanciesByDept = [];
$q = $conn->query("
    SELECT 
        d.Department_Name AS department,
        COUNT(v.Id) AS count
    FROM tbl_vacancies v
    INNER JOIN tbl_departments d ON d.Id = v.Department_Id
    GROUP BY v.Department_Id
    ORDER BY count DESC
");
if ($q) {
    while ($r = $q->fetch_assoc()) {
        $vacanciesByDept[] = [
            'department' => $r['department'],
            'count'      => (int)$r['count']
        ];
    }
}

// 5) Top 5 Vacancies with Most Applications (Bar Graph)
$topVacanciesByApplications = [];
$q = $conn->query("
    SELECT 
        v.Job_Title AS job_title,
        v.Vacancy_Id AS vacancy_id,
        COUNT(a.Id) AS application_count
    FROM tbl_vacancies v
    INNER JOIN tbl_applications a ON a.Vacancy_Id = v.Vacancy_Id
    GROUP BY v.Vacancy_Id
    ORDER BY application_count DESC
    LIMIT 5
");
if ($q) {
    while ($r = $q->fetch_assoc()) {
        $topVacanciesByApplications[] = [
            'job_title'         => $r['job_title'],
            'vacancy_id'        => $r['vacancy_id'],
            'application_count' => (int)$r['application_count']
        ];
    }
}

// 6) Vacancies by Location
$vacanciesByLocation = [];
$q = $conn->query("
    SELECT 
        l.Location_Name AS location,
        COUNT(v.Id) AS count
    FROM tbl_vacancies v
    INNER JOIN tbl_locations l ON l.Id = v.Location_Id
    GROUP BY v.Location_Id
    ORDER BY count DESC
");
if ($q) {
    while ($r = $q->fetch_assoc()) {
        $vacanciesByLocation[] = [
            'location' => $r['location'],
            'count'    => (int)$r['count']
        ];
    }
}

// FINAL RESPONSE
echo json_encode([
    'success'                    => 'true',
    'pageData'                   => $counts,
    'applicationStatus'          => $applicationStatus,
    'vacanciesByDept'            => $vacanciesByDept,
    'topVacanciesByApplications' => $topVacanciesByApplications,
    'vacanciesByLocation'        => $vacanciesByLocation
]);

$conn->close();