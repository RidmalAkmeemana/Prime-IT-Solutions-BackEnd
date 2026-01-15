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
    <title><?php echo ($companyName); ?> - Order Package</title>
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

    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- FORM MUST BE INSIDE modal-content -->
                <form id="orderForm">

                    <div class="modal-header">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Email</label><label class="text-danger">*</label>
                            <input style="display:none;" name="Package_Id" id="modalPackageId" class="form-control" required readonly>
                            <input type="email" name="Customer_Email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Customer Name</label><label class="text-danger">*</label>
                            <input type="text" name="Customer_Name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Contact Number</label><label class="text-danger">*</label>
                            <input type="text" name="Customer_Contact" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Customer Address</label><label class="text-danger">*</label>
                            <textarea name="Customer_Address" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Event Location</label><label class="text-danger">*</label>
                            <textarea name="Event_Location" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Date & Time</label><label class="text-danger">*</label>
                            <input type="datetime-local" name="Event_DateTime" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Submit Order
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php
        require '../Models/menu.php';
        ?>
        <!-- /Header -->

        <!-- Page Content -->
        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 col-12"> <!-- Center and limit width -->
                        <section class="section section-specialities ">
                            <div class="section-header text-center">
                                <h2>Order Package</h2>
                            </div>

                            <!-- PACKAGE CARD -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="booking-doc-info">
                                        <div class="booking-info">
                                            <h4 id="packageName"></h4>
                                            <h1 id="packagePrice"></h1>
                                            <div id="packageDescription"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ADDONS SECTION -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Addons</h5>
                                </div>
                                <div class="card-body" id="addonContainer"></div>
                                <div class="card-body text-danger">
                                    <i class="fas fa-info-circle"></i> Delivery fee will be added at the end depending on the location. (delivery setup and breakdown + tax)
                                </div>
                            </div>

                            <!-- SUBMIT -->
                            <div class="submit-section text-center">
                                <a href="javascript:void(0);" id="proceedBtn" class="btn btn-primary submit-btn">
                                    Proceed
                                </a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

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
        // Global variable to store invoice data        
        let CompanyName = '';
        let CompanyAddress = '';
        let CompanyEmail = '';
        let CompanyTel1 = 'N/A';
        let CompanyTel2 = 'N/A';
        let CompanyTel3 = 'N/A';

        $(document).ready(function() {

            fetchCompanyDetails();

            /* ===============================
               GET Package_Id from URL
            ================================ */
            const urlParams = new URLSearchParams(window.location.search);
            const packageId = urlParams.get('Package_Id');

            if (!packageId) {
                alert('Package Id missing');
                return;
            }

            /* ===============================
               LOAD PACKAGE & ADDONS
            ================================ */
            $.ajax({
                url: '../../API/Public/viewPackageData.php',
                type: 'GET',
                data: {
                    Package_Id: packageId
                },
                dataType: 'json',
                success: function(response) {

                    console.log('API RESPONSE:', response); // JSON only

                    /* PACKAGE DATA */
                    if (response.packageData) {
                        $('#packageName').text(response.packageData.Package_Name);
                        $('#packagePrice').text('$' + parseFloat(response.packageData.Price).toFixed(2));
                        $('#packageDescription').html(response.packageData.Package_Description);
                    }

                    /* ADDONS */
                    let addonHtml = '';

                    if (response.addons && response.addons.length > 0) {
                        $.each(response.addons, function(i, addon) {
                            addonHtml += `
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox"
                                   class="custom-control-input addon-checkbox"
                                   id="addon_${addon.Id}"
                                   value="${addon.Id}"
                                   data-price="${addon.Addon_Price}">
                            <label class="custom-control-label" for="addon_${addon.Id}">
                                ${addon.Addon_Name}
                                <span class="text-muted">
                                    ($${parseFloat(addon.Addon_Price).toFixed(2)})
                                </span>
                            </label>
                        </div>
                    `;
                        });
                    } else {
                        addonHtml = `<p class="text-muted">No addons available</p>`;
                    }

                    $('#addonContainer').html(addonHtml);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX ERROR:', error);
                }
            });

            /* ===============================
               OPEN CUSTOMER MODAL
            ================================ */
            $('#proceedBtn').on('click', function() {
                $('#modalPackageId').val(packageId);
                $('#customerModal').modal('show');
            });

            // CUSTOMER DETAILS
            $('#orderForm').on('blur', 'input[name="Customer_Email"]', function() {
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
               SUBMIT ORDER
            ================================ */
            $('#orderForm').on('submit', function(e) {
                e.preventDefault();

                $('#pageLoader').show(); // Show loader before sending

                let addons = [];
                $('.addon-checkbox:checked').each(function() {
                    addons.push({
                        Addon_Id: $(this).val(),
                        //Addon_Name: $(this).next('label').clone().children().remove().end().text().trim(),
                        Addon_Name: $(this).next('label').text().trim(),
                        Addon_Price: $(this).data('price')
                    });
                });

                let formData = $(this).serializeArray();
                formData.push({
                    name: 'addons',
                    value: JSON.stringify(addons)
                });

                $.ajax({
                    url: '../../API/Public/saveOrder.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {

                            const confirmationPdfUrl = '<?php echo $base_url; ?>API/Public/generateOrderConfirmation.php?order_id='

                            + res.Order_Id
                            + '&customerName=' + encodeURIComponent(res.Customer_Name)
                            + '&packageName=' + encodeURIComponent(res.Package_Name)
                            + '&eventLocation=' + encodeURIComponent(res.Event_Location)
                            + '&eventDateTime=' + encodeURIComponent(res.Event_DateTime)
                            + '&packagePrice=' + encodeURIComponent(res.Package_Price)
                            + '&addons=' + encodeURIComponent(JSON.stringify(addons));

                            // Send confirmation email
                            sendOrderConfirmationEmail(
                                res.Order_Id,
                                res.Customer_Name,
                                res.Customer_Email,
                                res.Package_Name,
                                res.Event_Location,
                                res.Event_DateTime,
                                res.Package_Price,
                                addons,
                                confirmationPdfUrl
                            );

                            console.log('Order Details saved in DB');

                        } else {
                            console.error(res.message || 'Order placed unsuccess!');
                        }
                    },
                    error: function() {
                        alert('Server error');
                    }
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

            function sendOrderConfirmationEmail(orderId, customerName, customerEmail, packageName, eventLocation, eventDateTime, packagePrice, addons, confirmationPdfUrl) {

                if (!customerEmail) {
                    return;
                }

                const emailSubject = `Order Confirmation - ${orderId}`;
                let addonHtml = '';

                if (addons && addons.length > 0) {
                    addonHtml += `
                    <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">
                        <tr style="background:#f2f2f2;">
                            <td colspan="2" style="font-weight:bold;">Addon Details</td>
                        </tr>`;
                    addons.forEach(addon => {
                        addonHtml += `<tr><td>${addon.Addon_Name}</td></tr>`;
                    });
                    addonHtml += `</table>`;
                }

                const formattedPackagePrice = '$' + parseFloat(packagePrice).toFixed(2);

                const emailBody = `
                <div style="font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
                        
                        <!-- HEADER -->
                        <tr>
                            <td style="background:#b19316;padding:20px;text-align:center;color:#ffffff;">
                                <h2 style="margin:0;">Order Submission Confirmed</h2>
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
                                    Your booking has been <b>successfully submited</b>.
                                </p>

                                <!-- ORDER DETAILS -->
                                <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">
                                    <tr style="background:#f2f2f2;">
                                        <td colspan="2" style="font-weight:bold;">Order Details</td>
                                    </tr>
                                    <tr>
                                        <td><b>Order ID</b></td>
                                        <td>${orderId}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Package</b></td>
                                        <td>${packageName} (${formattedPackagePrice})</td>
                                    </tr>
                                    <tr>
                                        <td><b>Event Location</b></td>
                                        <td>${eventLocation}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Event Date & Time</b></td>
                                        <td>${eventDateTime}</td>
                                    </tr>
                                </table>

                                <!-- ADDON DETAILS -->
                                ${addonHtml} <!-- Will be empty if no addons -->

                                <p style="margin-top:20px;font-size:14px;color:#be3235; font-weight:bold;">
                                    Delivery fee will be added at the end depending on the location.<br>(delivery setup and breakdown + tax)
                                </p>

                                <p style="margin-top:20px;font-size:14px;color:#555;">
                                    Our team member will contact you shortly to discuss further details.
                                </p>

                                <p style="font-size:14px;color:#555;">
                                    If you have any questions, feel free to contact us.
                                </p>

                                <!-- DOWNLOAD BUTTON -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:25px;">
                                    <tr>
                                        <td align="center">
                                            <a href="${confirmationPdfUrl}"
                                            target="_blank"
                                            style="
                                                    display:inline-block;
                                                    padding:12px 25px;
                                                    background:#b19316;
                                                    color:#ffffff;
                                                    text-decoration:none;
                                                    font-size:14px;
                                                    font-weight:bold;
                                                    border-radius:5px;
                                            ">
                                                Download Submission (PDF)
                                            </a>
                                        </td>
                                    </tr>
                                </table>
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
                            alert('Order placed & confirmation E-mail sent successfully!');
                            window.location.href = 'index.php';
                        } else {
                            alert('Order placed & confirmation e-mail sent unsuccess!');
                            window.location.href = 'index.php';
                        }
                    },
                    error: function() {
                        alert('Order placed & confirmation e-mail sent unsuccess!');
                    },
                    complete: function() {
						$('#pageLoader').hide(); // Hide loader after response (success or error)
					}
                });
            }
        });
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