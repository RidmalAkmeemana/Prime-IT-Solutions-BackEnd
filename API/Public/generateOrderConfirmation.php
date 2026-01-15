<?php
require_once '../../dompdf/autoload.inc.php';
require_once '../../API/Connection/config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Get data from GET
$orderId = $_GET['order_id'] ?? '';
$customerName = $_GET['customerName'] ?? '';
$packageName = $_GET['packageName'] ?? '';
$eventLocation = $_GET['eventLocation'] ?? '';
$eventDateTime = $_GET['eventDateTime'] ?? '';
$addonsJson = $_GET['addons'] ?? '[]'; // Addons passed as JSON string
$addonsArray = json_decode($addonsJson, true);

// Fetch company details
$q = mysqli_query($conn, "SELECT * FROM tbl_company_info LIMIT 1");
$c = mysqli_fetch_assoc($q);

$CompanyName = $c['Company_Name'];
$CompanyAddress = $c['Company_Address'];
$CompanyEmail = $c['Company_Email'];
$CompanyTel1  = $c['Company_Tel1'] ?? 'N/A';

// Prepare Addon HTML
$addonHtml = '';
if (!empty($addonsArray)) {
    $addonHtml .= "<table width='100%' cellpadding='8' cellspacing='0' style='border-collapse:collapse;margin-top:20px;'>";
    $addonHtml .= "<tr style='background:#f2f2f2;'><td colspan='2' style='font-weight:bold;'>Addon Details</td></tr>";
    foreach ($addonsArray as $addon) {
        $addonName = htmlspecialchars($addon['Addon_Name'] ?? '');
        $addonHtml .= "<tr><td>{$addonName}</td></tr>";
    }
    $addonHtml .= "</table>";
}

// Dompdf options
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// HTML content
$html = "
    <div style='font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;'>
        
        <!-- HEADER -->
        <tr>
            <td style='background:#b19316;padding:20px;text-align:center;color:#ffffff;'>
                <h2 style='margin:0;'>Order Submission Confirmed</h2>
            </td>
        </tr>

        <tr>
            <td style='padding-top:20px;text-align:center;'>
                <img src='https://uat.orbislk.com/Bloomdecouse/Web/Views/assets/img/logo.png' alt='Logo'>
            </td>
        </tr>

        <!-- BODY -->
        <tr>
            <td style='padding:30px;'>
                <p style='font-size:15px;color:#333;'>Dear <b>{$customerName}</b>,</p>

                <p style='font-size:14px;color:#555;'>
                    Thank you for choosing <b>{$CompanyName}</b>.  
                    Your booking has been <b>successfully submitted</b>.
                </p>

                <!-- ORDER DETAILS -->
                <table width='100%' cellpadding='8' cellspacing='0' style='border-collapse:collapse;margin-top:20px;'>
                    <tr style='background:#f2f2f2;'>
                        <td colspan='2' style='font-weight:bold;'>Order Details</td>
                    </tr>
                    <tr><td><b>Order ID</b></td><td>{$orderId}</td></tr>
                    <tr><td><b>Package</b></td><td>{$packageName}</td></tr>
                    <tr><td><b>Event Location</b></td><td>{$eventLocation}</td></tr>
                    <tr><td><b>Event Date & Time</b></td><td>{$eventDateTime}</td></tr>
                </table>

                <!-- ADDON DETAILS -->
                {$addonHtml}

                <p style='margin-top:20px;font-size:14px;color:#be3235;font-weight:bold;'>
                    Delivery fee will be added at the end depending on the location.<br>(delivery setup and breakdown + tax)
                </p>

                <p style='margin-top:20px;font-size:14px;color:#555;'>
                    Our team member will contact you shortly to discuss further details.
                </p>

                <p style='font-size:14px;color:#555;'>
                    If you have any questions, feel free to contact us.
                </p>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td style='background:#f9f9f9;padding:20px;text-align:center;font-size:12px;color:#777;'>
                <b>{$CompanyName}</b><br>
                {$CompanyAddress}<br>
                Email: {$CompanyEmail}<br>
                Contact: {$CompanyTel1}
            </td>
        </tr>
    </table>
</div>
";

// Render PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Force download
$dompdf->stream("Order_Confirmation_{$orderId}.pdf", ["Attachment" => true]);
exit;
