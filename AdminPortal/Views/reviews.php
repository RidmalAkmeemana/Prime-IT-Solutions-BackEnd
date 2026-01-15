<?php
require_once '../../API/Connection/validator.php';
require_once '../../API/Connection/config.php';
require_once '../../API/Connection/ScreenPermission.php';

// Fetch Company Name from the database
$companyName = ""; // Default name if query fails

$query = "SELECT Company_Name FROM tbl_company_info LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$companyName = $row['Company_Name'];
}

// Fetch user permissions (assuming you have a function for this)
$username = $_SESSION['user'];
$query = mysqli_query($conn, "SELECT * FROM `tbl_user` WHERE `username` = '$username'") or die(mysqli_error());
$fetch = mysqli_fetch_array($query);
$user_status = $fetch['Status'];

// Check if user has access to updateReviews.php
$has_access_to_edit_review = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 203") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_review = true;
}

// Check if user has access to deleteReviews.php
$has_access_to_delete_review = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 204") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_review = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Reviews</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feathericon.min.css">

	<!-- Datatables CSS -->
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/dark_mode_style.css">

	<!-- Select2 CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

	<style>
		.select2-container--default .select2-selection--single {
			height: 38px;
			/* Adjust this value as needed */
			padding: 6px;
			font-size: 14px;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 26px;
			/* Adjust to align text vertically */
		}

		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 38px;
			/* Adjust this value to match the height */
		}

		.select2-dropdown {
			max-height: 300px;
			/* Adjust the dropdown height */
			overflow-y: auto;
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
		<div class="header">

			<!-- Logo -->
			<div class="header-left">
				<a href="home.php" class="logo">
					<img src="assets/img/logo.png" alt="Logo">
				</a>
				<a href="home.php" class="logo logo-small">
					<img src="assets/img/logo-small.png" alt="Logo">
				</a>
			</div>
			<!-- /Logo -->

			<a href="javascript:void(0);" id="toggle_btn">
				<i class="fe fe-text-align-left"></i>
			</a>

			<!-- Mobile Menu Toggle -->
			<a class="mobile_btn" id="mobile_btn">
				<i class="fa fa-bars"></i>
			</a>
			<!-- /Mobile Menu Toggle -->

			<!-- Header Right Menu -->
			<ul class="nav user-menu">

				<!-- User Menu -->
				<?php
				require '../Models/usermenu.php';
				?>
				<!-- /User Menu -->

			</ul>
			<!-- /Header Right Menu -->

		</div>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php
		require '../Models/sidebar.php';
		?>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">Reviews</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Reviews</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- /Model Alerts -->
				<?php
				require '../Models/alerts.php';
				?>
				<!-- /Model Alerts -->

				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="datatable table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>#</th>
												<th>Customer Name</th>
												<th>Customer Email</th>
												<th>Ratings</th>
												<th>Message</th>
												<th>Is Active</th>
												<th>Created Date</th>
												<th>Action</th>
											</tr>
										</thead>

										<tbody>
											<!-- Data will be populated here -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->

		<!-- Delete Modal -->
		<div class="modal fade" id="Delete_Review" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Delete</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-content p-2">
							<h4 class="modal-title">Delete Review Id: <span id="deleteReview"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteReview.php" id="deleteReviewForm" enctype="multipart/form-data">
								<input style="display: none;" type="text" name="Id" required="" readonly="true">
								<button type="submit" name="delete" class="btn btn-primary btn-block">Delete </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete Modal -->

	</div>
	<!-- /Main Wrapper -->

	<?php
	require '../Models/footer.php';
	?>

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Datatables JS -->
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/datatables.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

	<!-- Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/9lf9h735jucnqfgf4ugu8egij1icgzsrgbcmsk5tg44cjba8/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

	<script>
		// GLOBAL ALERT FUNCTIONS
		function showSaveAlerts(response) {
			$('#Add_Addon').modal('hide');

			if (response.success === 'true') {
				$('#SaveSuccessModel').modal('show');
			} else if (response.success === 'false' && response.error === 'duplicate') {
				$('#SaveDuplicateModel').modal('show');
			} else {
				$('#SaveFailedModel').modal('show');
			}
		}

		function showUpdateAlerts(response) {
			$('#Update_Addon').modal('hide');

			if (response.success === 'true') {
				$('#UpdateSuccessModel').modal('show');
			} else if (response.success === 'false' && response.error === 'duplicate') {
				$('#UpdateDuplicateModel').modal('show');
			} else {
				$('#UpdateFailedModel').modal('show');
			}
		}

		function showDeleteAlerts(response) {
			$('#Delete_Review').modal('hide');

			if (response.success === 'true') {
				$('#DeleteSuccessModel').modal('show');
			} else {
				$('#DeleteFailedModel').modal('show');
			}
		}

		// DOCUMENT READY
		$(document).ready(function() {

			function renderStars(starRating) {
				starRating = parseInt(starRating, 10);
				let starsHtml = '';

				for (let i = 1; i <= 5; i++) {
					if (i <= starRating) {
						starsHtml += `<i class="fe fe-star text-warning"></i> `;
					} else {
						starsHtml += `<i class="fe fe-star-o text-secondary"></i> `;
					}
				}

				return starsHtml;
			}

			// PAGE LOADER
			let startTime = performance.now();
			window.addEventListener("load", function() {
				let endTime = performance.now();
				let loadTime = endTime - startTime;
				let delay = Math.max(loadTime);
				setTimeout(function() {
					$("#pageLoader").hide();
				}, delay);
			});

			// DATA TABLE FETCH
			$.ajax({
				type: 'POST',
				url: '../../API/Admin/getAllReviewsData.php',
				dataType: 'json',
				success: function (data) {
					if (data.length > 0) {

						const canEdit   = <?php echo $has_access_to_edit_review ? 'true' : 'false'; ?>;
						const canDelete = <?php echo $has_access_to_delete_review ? 'true' : 'false'; ?>;

						$('.datatable').DataTable().destroy();

						var table = $('.datatable').DataTable({
							searching: true,
						});

						table.clear();

						$.each(data, function (index, row) {

							const stars = renderStars(row.Star_Rating);
							const toggleId = `status_${row.Id}`;

							const statusToggle = canEdit
								? `
									<div class="status-toggle">
										<input type="checkbox"
											id="${toggleId}"
											class="check"
											${row.Is_Approved === "1" ? "checked" : ""}
											data-id="${row.Id}">
										<label for="${toggleId}" class="checktoggle">checkbox</label>
									</div>
								`
								: '';

							const deleteButton = canDelete
								? `
									<div class="actions">
										<a href="javascript:void(0);"
										class="btn btn-sm bg-danger-light ms-1 delete-addon-btn"
										data-id="${row.Id}">
											<i class="fe fe-trash"></i> Delete
										</a>
									</div>
								`
								: '';

							table.row.add([
								row.Id,
								row.Customer_Name,
								row.Customer_Email,
								stars,
								row.Message,
								statusToggle,
								row.Created_Date,
								deleteButton
							]);
						});

						table.draw();

						if (!canEdit) {
							table.column(5).visible(false); // Hide "Is Active"
						}

						if (!canDelete) {
							table.column(7).visible(false); // Hide "Action"
						}
					}
				},
				error: function (xhr, status, error) {
					console.error('Error fetching reviews:', status, error);
				}
			});

			// DELETE REVIEW
			$(document).on('click', '.delete-addon-btn', function() {
				const Id = $(this).data('id');

				$('#Delete_Review input[name="Id"]').val(Id);
				$('#deleteReview').text(Id);
				$('#Delete_Review').modal('show');
			});

			$('#deleteReviewForm').submit(function(e) {
				e.preventDefault();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/deleteReview.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showDeleteAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Delete_Review').modal('hide');
						$('#DeleteFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#DeleteSuccessModel #OkBtn').click(function() {
				window.location.href = 'reviews.php';
			});

			// CURRENCY INPUT VALIDATION
			$(document).on('input', '.currency-input', function() {
				let enteredValue = parseFloat($(this).val());
				if (isNaN(enteredValue) || enteredValue < 0) {
					$(this).val('');
				}
			});

		});

		$(document).on('change', '.status-toggle .check', function () {

			const checkbox = $(this);
			const Id = checkbox.data('id');
			const Is_Approved = checkbox.is(':checked') ? 1 : 0;

			$('#pageLoader').show();

			$.ajax({
				type: 'POST',
				url: '../../API/Admin/updateReview.php',
				data: {
					Id: Id,
					Is_Approved: Is_Approved
				},
				dataType: 'json',
				success: function (response) {

					if (response.success !== 'true') {
						// Revert toggle if failed
						checkbox.prop('checked', !checkbox.is(':checked'));
						$('#UpdateFailedModel').modal('show');
					}
				},
				error: function () {
					// Revert toggle on error
					checkbox.prop('checked', !checkbox.is(':checked'));
					$('#UpdateFailedModel').modal('show');
				},
				complete: function () {
					$('#pageLoader').hide();
				}
			});
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

</html>