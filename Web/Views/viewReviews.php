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
    <title><?php echo ($companyName); ?> - Reviews</title>
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

        <!-- Popular Section -->
        <section class="section section-doctor">
            <div class="container-fluid">
                <div class="row" id="reviewContainer"></div>
            </div>

            <!-- SUBMIT -->
            <div class="submit-section text-center">
                <a href="javascript:void(0);" id="postBtn" class="btn btn-primary submit-btn">
                    Post Review
                </a>
            </div>
        </section>
        <!-- /Popular Section -->
    </div>
    <!-- /Main Wrapper -->

    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- FORM MUST BE INSIDE modal-content -->
                <form id="reviewForm">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Review</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Email</label><label class="text-danger">*</label>
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

                        <label>Add Star Rating</label><label class="text-danger">*</label>
                        <div class="star-rating">
                            <input id="star-5" type="radio" name="rating" value="5">
                            <label for="star-5" title="5 stars">
                                <i class="active fa fa-star"></i>
                            </label>
                            <input id="star-4" type="radio" name="rating" value="4">
                            <label for="star-4" title="4 stars">
                                <i class="active fa fa-star"></i>
                            </label>
                            <input id="star-3" type="radio" name="rating" value="3">
                            <label for="star-3" title="3 stars">
                                <i class="active fa fa-star"></i>
                            </label>
                            <input id="star-2" type="radio" name="rating" value="2">
                            <label for="star-2" title="2 stars">
                                <i class="active fa fa-star"></i>
                            </label>
                            <input id="star-1" type="radio" name="rating" value="1">
                            <label for="star-1" title="1 star">
                                <i class="active fa fa-star"></i>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Message</label><label class="text-danger">*</label>
                            <textarea name="Message" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Save Review
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

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
            $.ajax({
                url: '../../API/Public/getAllReviewData.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    let html = '';

                    if (data.length === 0) {
                        html = `<div class="col-12 text-center">No reviews available</div>`;
                    }

                    $.each(data, function(index, row) {

                        html += `
                    <div class="col-lg-12 col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">

                                <h5 class="card-title mb-2">${row.Customer_Name}</h5>

                                <div class="mb-2">
                                    ${renderStars(row.Star_Rating)}
                                </div>

                                <p class="card-text text-muted">
                                    “${escapeHtml(row.Message)}”
                                </p>

                                <small class="text-secondary">
                                    ${formatDate(row.Created_Date)}
                                </small>

                            </div>
                        </div>
                    </div>`;
                    });

                    $('#reviewContainer').html(html);
                },
                error: function() {
                    $('#reviewContainer').html(
                        `<div class="col-12 text-center text-danger">Failed to load reviews</div>`
                    );
                }
            });

            /* ===============================
               OPEN CUSTOMER MODAL
            ================================ */
            $('#postBtn').on('click', function() {
                $('#reviewModal').modal('show');
            });

            // CUSTOMER DETAILS
            $('#reviewForm').on('blur', 'input[name="Customer_Email"]', function() {
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
               SUBMIT REVIEW
            ================================ */
            $('#reviewForm').on('submit', function(e) {
                e.preventDefault();

                $('#pageLoader').show();

                $.ajax({
                    url: '../../API/Public/saveReview.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            alert('Review submitted successfully. Pending approval.');
                            $('#reviewModal').modal('hide');
                            location.reload();
                        } else {
                            alert(res.message || 'Failed to save review');
                        }
                    },
                    error: function() {
                        alert('Server error');
                    },
                    complete: function() {
                        $('#pageLoader').hide();
                    }
                });
            });

        });

        /* =========================
        STAR RENDER FUNCTION
        ========================= */
        function renderStars(rating) {
            rating = parseInt(rating);
            let stars = '';

            for (let i = 1; i <= 5; i++) {
                stars += i <= rating ?
                    `<i class="fas fa-star text-warning"></i>` :
                    `<i class="far fa-star text-secondary"></i>`;
            }

            return stars;
        }

        /* =========================
        FORMAT DATE
        ========================= */
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        /* =========================
        PREVENT HTML BREAKING
        ========================= */
        function escapeHtml(text) {
            return $('<div>').text(text).html();
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