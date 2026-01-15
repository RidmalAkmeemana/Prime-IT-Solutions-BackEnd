<?php
require_once '../../API/Connection/config.php';
include '../../API/Connection/uploadurl.php';

// Fetch Company Name from the database
$companyName = ""; // Default name if query fails

$query = "SELECT Company_Name FROM tbl_company_info LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $companyName = $row['Company_Name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- doccure/booking.html  30 Nov 2019 04:12:16 GMT -->

<head>
    <meta charset="utf-8">
    <title><?php echo ($companyName); ?> - Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

    <style>
        .background-container {
            background-size: cover;
            background-position: center;
            height: 250px;
            /* Adjust the height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .tag-cloud {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 5px;
            background-color: #b19316;
            color: #ffff;
            margin-top: 8px;
            width: 100%;
        }

        /* Black Back Button */
        .btn-back {
            background-color: black;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #333;
            color: white;
        }

        /* Full-Screen Loader */
        #pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Spinner Animation */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #b19316;
            border-top: 5px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Full-Screen Loader */
    </style>

</head>

<body>

    <!-- Full-Screen Loader -->
    <div id="pageLoader">
        <div class="loader-content" style="display: flex; flex-direction: column; align-items: center;">
            <div class="spinner"></div>
            <div style="margin-top: 10px; font-size: 16px;">Loading . . .</div>
        </div>
    </div>
    <!-- /Full-Screen Loader -->

    <!-- Header -->
    <?php
    require '../Models/menu.php';
    ?>
    <!-- /Header -->

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="container mt-5 mb-5">

            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">Contact Us</h4>
                </div>

                <div class="card-body">
                    <form id="contactForm">

                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="Customer_Email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="Customer_Name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="Customer_Contact" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Customer Address <span class="text-danger">*</span></label>
                            <textarea name="Customer_Address" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" name="Subject" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea name="Message" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Send Message
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /Main Wrapper -->

    <!-- Footer -->
    <?php
    require '../Models/footer.php';
    ?>
    <!-- /Footer -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script>
        $(document).ready(function() {

            fetchCompanyDetails();

            // CUSTOMER DETAILS
            $('#contactForm').on('blur', 'input[name="Customer_Email"]', function() {
                let CustomerEmail = $(this).val();

                if (CustomerEmail) {
                    // Make an AJAX request to fetch customer details
                    $.ajax({
                        type: 'POST',
                        url: '../../API/Public/getCustomerDetails.php', // Endpoint to fetch customer details
                        data: {
                            Customer_Email: CustomerEmail
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Populate fields with the fetched data
                                $('input[name="Customer_Name"]').val(response.data.Customer_Name);
                                $('input[name="Customer_Contact"]').val(response.data.Customer_Contact);
                                $('textarea[name="Customer_Address"]').val(response.data.Customer_Address.replace(/<\/?[^>]+(>|$)/g, ""));
                            } else {
                                // Clear fields if not found
                                $('input[name="Customer_Name"], input[name="Customer_Contact"]').val('');
                                $('textarea[name="Customer_Address"]').val('');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching customer details:', status, error);
                        }
                    });
                }
            });

            /* ===============================
               SUBMIT RECORD
            ================================ */
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                $('#pageLoader').show();

                $.ajax({
                    url: '../../API/Public/saveDetails.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {

                            // Send confirmation email
                            sendConfirmationEmail(
                                res.Customer_Name,
                                res.Customer_Email,
                                res.Subject,
                                res.Message
                            );

                            // Send reciver email
                            sendSubmitEmail(
                                res.Customer_Name,
                                res.Customer_Email,
                                res.Customer_Address,
                                res.Customer_Contact,
                                res.Subject,
                                res.Message
                            );

                            console.log('form submitted successfully.');

                        } else {
                            console.log(res.alert || 'Failed to save data');
                        }
                    },
                    error: function() {
                        console.log('Server error');
                    }
                });
            });
        });

        function fetchCompanyDetails() {
            $.ajax({
                type: 'GET',
                url: '../../API/Public/getCompanyDetails.php',
                dataType: 'json',
                success: function(response) {
                    CompanyName = response.Company_Name;
                    CompanyAddress = response.Company_Address;
                    CompanyEmail = response.Company_Email;
                    CompanyTel1 = response.Company_Tel1 && response.Company_Tel1.trim() !== '' ? response.Company_Tel1 : 'N/A';
                    CompanyTel2 = response.Company_Tel2 && response.Company_Tel2.trim() !== '' ? response.Company_Tel2 : 'N/A';
                    CompanyTel3 = response.Company_Tel3 && response.Company_Tel3.trim() !== '' ? response.Company_Tel3 : 'N/A';
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching company details:', status, error);
                }
            });
        }

        function sendConfirmationEmail(customerName, customerEmail, subject, message) {

            if (!customerEmail) {
                return;
            }

            const emailSubject = `Inquiry Submission`;

            const emailBody = `
            <div style="font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    
                    <!-- HEADER -->
                    <tr>
                        <td style="background:#b19316;padding:20px;text-align:center;color:#ffffff;">
                            <h2 style="margin:0;">Confirmation</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px;text-align:center;">
                            <img src="https://uat.orbislk.com/Bloomdecouse/Web/Views/assets/img/logo.png" alt="Logo">
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px;color:#333;">
                                Dear <b>${customerName}</b>,
                            </p>

                            <p style="font-size:14px;color:#555;">
                                Thank you for choosing <b>${CompanyName}</b>.  
                                Your inquiry has been <b>successfully submited</b>. Our team member will contact you shortly to discuss further details.
                            </p>
                            <p style="font-size:15px;color:#333;">Thanks & Regards <br><b>${CompanyName}</b>,</p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9f9f9;padding:20px;text-align:center;font-size:12px;color:#777;">
                            <b>${CompanyName}</b><br>
                            ${CompanyAddress}<br>
                            Email: ${CompanyEmail}<br>
                            Contact: ${CompanyTel1}
                        </td>
                    </tr>

                </table>
            </div>
            `;

            sendEmail(
                CompanyEmail,
                CompanyName,
                customerEmail,
                emailSubject,
                emailBody
            );
        }

        function sendSubmitEmail(customerName, customerEmail, customerAddress, customerContact, subject, message) {

            if (!customerEmail) {
                return;
            }

            const emailSubject = `New Inquiry | ${subject}`;

            const emailBody = `
            <div style="font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    
                    <!-- HEADER -->
                    <tr>
                        <td style="background:#b19316;padding:20px;text-align:center;color:#ffffff;">
                            <h2 style="margin:0;">Inquiry</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:20px;text-align:center;">
                            <img src="https://uat.orbislk.com/Bloomdecouse/Web/Views/assets/img/logo.png" alt="Logo">
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px;color:#333;">
                                New inquiry from <b>${customerName}</b>,
                            </p>

                            <p style="font-size:14px;color:#555;">
                                ${message}  
                            </p>
                            <p style="font-size:15px;color:#333;">Thanks & Regards 
                                <br><b>${customerName}</b>,
                                <br><b>${customerAddress}</b>,
                                <br><b>${customerEmail}</b>,
                                <br><b>${customerContact}</b>
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9f9f9;padding:20px;text-align:center;font-size:12px;color:#777;">
                            <b>${CompanyName}</b><br>
                            ${CompanyAddress}<br>
                            Email: ${CompanyEmail}<br>
                            Contact: ${CompanyTel1}
                        </td>
                    </tr>

                </table>
            </div>
            `;

            reciverEmail(
                customerEmail,
                customerName,
                CompanyEmail,
                emailSubject,
                emailBody
            );
        }

        function sendEmail(from, name, to, subject, body) {
            $('#pageLoader').show(); // Show loader before sending

            $.ajax({
                url: '../../sendEmail.php',
                type: 'POST',
                data: {
                    from: from,
                    name: name,
                    to: to,
                    subject: subject,
                    body: body
                },
                success: function(response) {
                    if (response.success === true) {
                        console.log('confirmation E-mail sent successfully!');
                        location.reload();
                    } else {
                        console.log('confirmation e-mail sent unsuccess!');
                    }
                },
                error: function() {
                    console.log('confirmation e-mail sent unsuccess!');
                }
            });
        }

        function reciverEmail(from, name, to, subject, body) {
            $('#pageLoader').show(); // Show loader before sending

            $.ajax({
                url: '../../sendEmail.php',
                type: 'POST',
                data: {
                    from: from,
                    name: name,
                    to: to,
                    subject: subject,
                    body: body
                },
                success: function(response) {
                    if (response.success === true) {
                        alert('E-mail sent successfully!');
                        location.reload();
                    } else {
                        alert('E-mail sent unsuccess!');
                    }
                },
                error: function() {
                    alert('E-mail sent unsuccess!');
                },
                complete: function() {
                    $('#pageLoader').hide(); // Hide loader after response (success or error)
                }
            });
        }
    </script>


    <!-- Loader Script -->
    <script>
        let startTime = performance.now(); // Capture the start time when the page starts loading

        window.addEventListener("load", function() {
            let endTime = performance.now(); // Capture the end time when the page is fully loaded
            let loadTime = endTime - startTime; // Calculate the total loading time

            // Ensure the loader stays for at least 500ms but disappears dynamically based on actual load time
            let delay = Math.max(loadTime);

            setTimeout(function() {
                document.getElementById("pageLoader").style.display = "none";
            }, delay);
        });
    </script>
    <!-- /Loader Script -->

</body>

<!-- doccure/booking.html  30 Nov 2019 04:12:16 GMT -->

</html>