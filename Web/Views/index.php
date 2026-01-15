<?php
require_once '../../API/Connection/config.php';

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

<!-- doccure/  30 Nov 2019 04:11:34 GMT -->

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Home</title>

	<!-- Favicons -->
	<link type="image/x-icon" href="assets/img/favicon.png" rel="icon">

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

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php
		require '../Models/menu.php';
		?>
		<!-- /Header -->

		<!-- Packages -->
		<section class="section section-specialities">
			<div class="container-fluid">
				<div class="section-header text-center">
					<h2>Our Packages</h2>
				</div>
				<div class="row justify-content-center">
					<?php
					require 'packageGrid.php';
					?>
				</div>
			</div>
		</section>
		<!-- Packages -->

		<!-- Reviews -->
		<section class="section section-doctor">
			<div class="section-header text-center">
				<h2>Testomonials</h2>
			</div>
            <div class="container-fluid">
                <div class="row" id="reviewContainer"></div>
            </div>
        </section>
		<!-- Reviews -->

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

	<!-- Slick JS -->
	<script src="assets/js/slick.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

	<!-- Loader Script -->

	<script>
    $(document).ready(function () {

        $.ajax({
            url: '../../API/Public/getRecentReviews.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                let html = '';

                if (data.length === 0) {
                    html = `<div class="col-12 text-center">No reviews available</div>`;
                }

                $.each(data, function (index, row) {

                    html += `
                    <div class="col-lg-4 col-md-6 mb-4">
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
            error: function () {
                $('#reviewContainer').html(
                    `<div class="col-12 text-center text-danger">Failed to load reviews</div>`
                );
            }
        });

    });

    /* =========================
    STAR RENDER FUNCTION
    ========================= */
    function renderStars(rating) {
        rating = parseInt(rating);
        let stars = '';

        for (let i = 1; i <= 5; i++) {
            stars += i <= rating
                ? `<i class="fas fa-star text-warning"></i>`
                : `<i class="far fa-star text-secondary"></i>`;
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

<!-- doccure/  30 Nov 2019 04:11:53 GMT -->

</html>