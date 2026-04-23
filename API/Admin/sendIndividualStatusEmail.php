<?php
require_once '../Connection/config.php';
include '../../API/Connection/uploadurl.php';

// RESPONSE TYPE
header('Content-Type: application/json');

// GET DATA FROM AJAX
$Individuals_Id     = $_POST['Individuals_Id'] ?? '';
$Status             = $_POST['Status'] ?? '';
$Message            = $_POST['Message'] ?? '';
$Job_Title          = $_POST['Job_Title'] ?? '';;
$Applicant_Name     = $_POST['Applicant_Name'] ?? '';
$Applicant_Address  = $_POST['Applicant_Address'] ?? '';
$Applicant_Contact  = $_POST['Applicant_Contact'] ?? '';
$Applicant_Email    = $_POST['Applicant_Email'] ?? '';

// VALIDATION
if (empty($Applicant_Email)) {
    echo json_encode(["success" => false, "message" => "Missing email"]);
    exit;
}

// FETCH COMPANY INFO
$companyQuery = mysqli_query($conn, "SELECT * FROM tbl_company_info LIMIT 1");
$company = mysqli_fetch_assoc($companyQuery);

// STATUS BADGE STYLE
$statusBadge = "";

if ($Status == 'Pending') {
    $statusBadge = '<span style="background:#ffc107;color:#000;padding:5px 10px;border-radius:4px;font-size:12px;">Pending</span>';
}
else if ($Status == 'Sort Listed') {
    $statusBadge = '<span style="background:#6c757d;color:#fff;padding:5px 10px;border-radius:4px;font-size:12px;">Sort Listed</span>';
}
else if ($Status == 'Interview') {
    $statusBadge = '<span style="background:#0dcaf0;color:#000;padding:5px 10px;border-radius:4px;font-size:12px;">Interview</span>';
}
else if ($Status == 'Hired') {
    $statusBadge = '<span style="background:#0d6efd;color:#fff;padding:5px 10px;border-radius:4px;font-size:12px;">Hired</span>';
}
else if ($Status == 'Rejected') {
    $statusBadge = '<span style="background:#dc3545;color:#fff;padding:5px 10px;border-radius:4px;font-size:12px;">Rejected</span>';
}

// EMAIL TEMPLATE (YOUR DESIGN)
$body = '
<div style="font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;">
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
        
<tr>
<td style="background:#b72227;padding:20px;text-align:center;color:#ffffff;">
<h2 style="margin:0;">Application Status Update</h2>
</td>
</tr>

<tr>
<td style="padding-top:20px;text-align:center;">
<img src="https://res.cloudinary.com/dy5ciybdm/image/upload/v1775457537/logo_f8qm5r.png">
</td>
</tr>

<tr>
<td style="padding:30px;">

<p style="font-size:15px;color:#333;">
Dear <b>'.$Applicant_Name.'</b>,
</p>

<p style="font-size:14px;color:#555;"> 
'.$Message.'
</p>

<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">
<tr style="background:#f2f2f2;">
<td colspan="2"><b>Applicant Details</b></td>
</tr>

<tr><td><b>Application No</b></td><td>'.$Individuals_Id.'</td></tr>
<tr><td><b>Process Status</b></td><td>'.$statusBadge.'</td></tr>
<tr><td><b>Job Title</b></td><td>'.$Job_Title.'</td></tr>
<tr><td><b>Applicant Name</b></td><td>'.$Applicant_Name.'</td></tr>
<tr><td><b>Applicant Address</b></td><td>'.$Applicant_Address.'</td></tr>
<tr><td><b>Applicant Contact</b></td><td>'.$Applicant_Contact.'</td></tr>
<tr><td><b>Applicant Email</b></td><td>'.$Applicant_Email.'</td></tr>
</table>

</td>
</tr>

<tr>
<td style="background:#f9f9f9;padding:20px;text-align:center;font-size:12px;color:#777;">
<b>'.$company['Company_Name'].'</b><br>
'.$company['Company_Address'].'<br>
Email: '.$company['Company_Email'].'<br>
Contact: '.$company['Company_Tel1'].'
</td>
</tr>

</table>
</div>
';

// ==========================
// CALL sendEmail.php
// ==========================

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $base_url . 'sendEmail.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'from'    => 'orbissolutionslk@gmail.com',
    'name'    => $company['Company_Name'],
    'to'      => $Applicant_Email,
    'subject' => 'Application Status Update',
    'body'    => $body
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["success" => false, "message" => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// FINAL RESPONSE
echo json_encode([
    "success" => true,
    "message" => "Email sent successfully"
]);