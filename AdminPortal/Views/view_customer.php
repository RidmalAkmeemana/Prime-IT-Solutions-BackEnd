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

// Check if user has access to updateCustomer.php
$has_access_to_edit_customer = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 116") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_customer = true;
}

// Check if user has access to deleteCustomer.php
$has_access_to_delete_customer = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 105") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_customer = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Customers</title>

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

				<!-- /Model Alerts -->
				<?php
					require '../Models/alerts.php';
				?>
				<!-- /Model Alerts -->

				<!-- Page Header -->
				<div class="page-header">
					<?php
					$Customer_Id = $_REQUEST["Customer_Id"];
					$query1 = mysqli_query($conn, "SELECT * FROM tbl_customers WHERE `Customer_Id` = '$Customer_Id'") or die(mysqli_error());
					$fetch1 = mysqli_fetch_array($query1);
					?>

					<!-- Edit and Delete Buttons -->
					<div class="row">
						<div class="col-md-12 text-left">
							<?php if ($has_access_to_edit_customer): ?>
								<a href="#Update_Customer" id="editCustomerBtn" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php endif; ?>

							<?php if ($has_access_to_delete_customer): ?>
								<a href="#Delete_Customer" id="deleteCustomerBtn" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 text-center mt-4 position-relative">
							<div class="background-container" style="background-image: url('assets/img/cover.png');">
								<div class="col-md-12 text-center mt-4 page-title-container">
									<h1 class="text-xs font-weight-bold text-uppercase mb-1" id="customerName"></h1>
									<h5 class="text-xs font-weight-bold text-uppercase mb-1" id="customerId"></h5>
									<a href="home.php" class="breadcrumb-item" style="color: black;"><i class="fa fa-home"></i> Home</a>
									<a href="add_customers.php" class="breadcrumb-item active">Customers</a>
								</div>
							</div>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Customer Contact No</h5>
								<p class="mx-auto" id="customerContact"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Customer Email Address</h5>
								<p class="mx-auto" id="customerEmail"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Customer Address</h5>
								<p class="mx-auto" id="customerAddress"></p>
							</h5>
						</div>

						<div class="col-md-12 text-left mt-4">
							<h5 class="page-title">
								<h5 class="tag-cloud text-xs font-weight-bold mb-1">Recent Invoices</h5>
							</h5>
							<br><br>
							<div class="table-responsive">
								<table class="datatable table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Order ID</th>
											<th>Package Name</th>
											<th>Event Location</th>
											<th>Event Date & Time</th>
											<th>Status</th>
											<th>Order Date & Time</th>
										</tr>
									</thead>

									<tbody id="orderList">
										<!-- Data will be populated here -->
									</tbody>
								</table>
							</div>
							<!-- Back Button -->
							<div class="form-group text-right mt-5">
								<button onclick="window.history.back();" class="btn btn-back"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to List</button>
							</div>
							<!-- Back Button -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Edit Details Modal-->
		<div class="modal fade" id="Update_Customer" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Customer Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/updateCustomer.php" id="updateCustomerForm" enctype="multipart/form-data">
							<div class="row form-row">

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Customer Name</label><label class="text-danger">*</label>
										<input style="display:none;" type="text" name="Customer_Id" class="form-control" required="" readonly="true">
										<input type="text" name="Customer_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Customer Contact Number</label><label class="text-danger">*</label>
										<input type="text" name="Customer_Contact" class="form-control" required="">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Customer Email Address</label><label class="text-danger">*</label>
										<?php
										$Customer_Email =  $fetch1['Customer_Email'];

										if ($Customer_Email == '-') { ?>
											<input type="email" name="Customer_Email" class="form-control" required="">
										<?php	} else { ?>
											<input type="email" name="Customer_Email" class="form-control" required="">
										<?php	}
										?>
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Customer Address</label>
										<textarea id="edit-text" name="Customer_Address" class="form-control" rows="8"></textarea>
										<p id="count-result">0/1000</p>
									</div>
								</div>

							</div>
							<button type="submit" name="edit" class="btn btn-primary btn-block">Update Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--/Edit Details Modal -->

		<!-- Delete Modal -->
		<div class="modal fade" id="Delete_Customer" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="Customer_Name"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteCustomer.php" id="deleteCustomerForm" enctype="multipart/form-data">
								<input style="display:none;" type="text" name="Customer_Id" required="" readonly="true">
								<button type="submit" name="delete" class="btn btn-primary btn-block">Delete </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete Modal -->

		<!-- /Main Wrapper -->

		<!-- Footer -->
		<?php
		require '../Models/footer.php';
		?>
		<!-- /Footer -->

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
			$(document).ready(function() {

				// GLOBAL ALERT FUNCTIONS
				function showUpdateAlerts(response) {
					// Hide the Update Brand modal before showing any alert modals
					$('#Update_Customer').modal('hide');

					if (response.success === 'true') {
						// Show UpdateSuccessModel only if success is true
						$('#UpdateSuccessModel').modal('show');
					} else if (response.success === 'false' && response.error === 'duplicate') {
						// Show UpdateDuplicateModel only if success is false and error is duplicate
						$('#UpdateDuplicateModel').modal('show');
					} else {
						// Show UpdateFailedModel for any other failure scenario
						$('#UpdateFailedModel').modal('show');
					}
				}

				function showDeleteAlerts(response) {
					// Hide the Delete Brand modal before showing any alert modals
					$('#Delete_Customer').modal('hide');

					if (response.success === 'true') {
						// Show DeleteSuccessModel only if success is true
						$('#DeleteSuccessModel').modal('show');
					} else {
						// Show DeleteFailedModel for any other failure scenario
						$('#DeleteFailedModel').modal('show');
					}
				}

				// Function to fetch and display customer data
				function fetchCustomerData(Customer_Id) {

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

					$.ajax({
						type: 'GET',
						url: '../../API/Admin/viewCustomerData.php',
						data: {
							Customer_Id: Customer_Id
						},
						dataType: 'json',
						success: function(response) {
							if (!response.customerData) {
								console.error('Failed to fetch customer data');
								return;
							}

							$('#customerName').text(response.customerData.Customer_Name);
							$('#customerId').text(response.customerData.Customer_Id);
							$('#customerContact').text(response.customerData.Customer_Contact);
							$('#customerEmail').text(response.customerData.Customer_Email);
							$('#customerAddress').html(response.customerData.Customer_Address);

							//Edit Button on click
							$('#editCustomerBtn').on('click', function() {
								$('input[name="Customer_Id"]').val(response.customerData.Customer_Id);
								$('input[name="Customer_Name"]').val(response.customerData.Customer_Name);
								$('input[name="Customer_Contact"]').val(response.customerData.Customer_Contact);
								$('input[name="Customer_Email"]').val(response.customerData.Customer_Email);

								if (tinymce.get('edit-text')) {
									tinymce.get('edit-text').setContent(response.customerData.Customer_Address || '');
								}

								// Update character counter
								const textLength = (response.customerData.Customer_Address || '').replace(/<[^>]*>/g,'').length;
								$('#count-result').text(`${textLength} / 1000`);
							});

							//Delete Button on click
							$('#deleteCustomerBtn').on('click', function() {
								$('input[name="Customer_Id"]').val(response.customerData.Customer_Id);
								$('#Customer_Name').text(response.customerData.Customer_Name);
							});

							// TINYMCE INIT
							function initTinyMCE(selector, counterSelector) {
								tinymce.init({
									selector: selector,
									height: 250,
									menubar: false,
									branding: false,
									plugins: 'lists link',
									toolbar: 'bold italic underline | bullist numlist | undo redo',
									setup: function(editor) {
										const limit = 1000;
										const result = document.querySelector(counterSelector);

										editor.on('input keyup', function() {
											let text = editor.getContent({
												format: 'text'
											});
											let count = text.length;
											result.textContent = `${count} / ${limit}`;

											if (count > limit) {
												editor.getContainer().style.border = "1px solid #F08080";
												result.style.color = "#F08080";
											} else {
												editor.getContainer().style.border = "1px solid #1ABC9C";
												result.style.color = "#333";
											}
										});
									}
								});
							}

							initTinyMCE('#edit-text', '#Update_Customer #count-result');

							// Destroy existing DataTable, if any
							$('.datatable').DataTable().destroy();

							// Initialize DataTable
							var table = $('.datatable').DataTable({
								searching: true, // Enable search
							});

							// Clear existing rows
							table.clear();

							// Populate invoice list
							if (response.orders.length > 0) {
								$.each(response.orders, function(index, order) {

									let statusBadge = '';
									if (order.Status === 'Completed') {
										statusBadge = '<span class="badge badge-primary">Completed</span>';
									} else if (order.Status === 'Pending') {
										statusBadge = '<span class="badge badge-warning">Pending</span>';
									} else if (order.Status === 'Rejected') {
										statusBadge = '<span class="badge badge-secondary">Rejected</span>';
									} else if (order.Status === 'Approved') {
										statusBadge = '<span class="badge badge-info">Approved</span>';
									} else if (order.Status === 'Canceled') {
										statusBadge = '<span class="badge badge-danger">Canceled</span>';
									}

									table.row.add([
										order.Order_Id,
										order.Package_Name,
										order.Event_Location,
										order.Event_DateTime,
										statusBadge,
										order.Order_Date
									]);
								});
							} else {
								console.log('No data received.');
							}

							// Draw the table
							table.draw();
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
						}
					});
				}

				// Get the Customer_Id from the URL
				const urlParams = new URLSearchParams(window.location.search);
				const Customer_Id = urlParams.get('Customer_Id');
				// Fetch and display customer data
				fetchCustomerData(Customer_Id);

				// Function to edit a customer
				$('#updateCustomerForm').submit(function(event) {

					event.preventDefault();

					let descriptionText = tinymce.get('edit-text').getContent({
						format: 'text'
					}).trim();

					if (!descriptionText.length) {
						$('#Update_Customer').modal('hide');
						$('#EmptyAddress').modal('show');
						tinymce.get('edit-text').focus();
						return false;
					}

					tinymce.triggerSave();

					$('#pageLoader').show(); // Show loader before sending

					$.ajax({
						type: 'POST',
						url: '../../API/Admin/updateCustomer.php',
						data: $(this).serialize(),
						success: function(response) {
							// Parse the response as a JSON object (if not already parsed)
							if (typeof response === 'string') {
								response = JSON.parse(response);
							}

							// Show the appropriate modal based on response
							showUpdateAlerts(response);

							// Log the response for debugging
							console.log(response);
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
							$('#Update_Customer').modal('hide');
							$('#UpdateFailedModel').modal('show');
						},
						complete: function() {
							$('#pageLoader').hide(); // Hide loader after response (success or error)
						}
					});
				});

				// Handle the "Ok" button click in the UpdateSuccessModel
				$('#UpdateSuccessModel #OkBtn').on('click', function() {
					// Refresh the page when "Ok" is clicked
					window.location.href = 'add_customers.php';
				});

				// Function to delete a customer
				$('#deleteCustomerForm').submit(function(event) {

					event.preventDefault();

					$('#pageLoader').show(); // Show loader before sending

					$.ajax({
						type: 'POST',
						url: '../../API/Admin/deleteCustomer.php',
						data: $(this).serialize(),
						success: function(response) {
							// Parse the response as a JSON object (if not already parsed)
							if (typeof response === 'string') {
								response = JSON.parse(response);
							}

							// Show the appropriate modal based on response
							showDeleteAlerts(response);

							// Log the response for debugging
							console.log(response);
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
							$('#Delete_Customer').modal('hide');
							$('#DeleteFailedModel').modal('show');
						},
						complete: function() {
							$('#pageLoader').hide(); // Hide loader after response (success or error)
						}
					});
				});

				// Handle the "Ok" button click in the DeleteSuccessModel
				$('#DeleteSuccessModel #OkBtn').on('click', function() {
					// Refresh the page when "Ok" is clicked
					window.location.href = 'add_customers.php';
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

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:51 GMT -->

</html>