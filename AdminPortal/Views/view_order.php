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
$has_access_to_edit_order = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 200") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_order = true;
}

// Check if user has access to deleteCustomer.php
$has_access_to_delete_order = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 201") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_order = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Orders</title>

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

	<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->


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
					$Order_Id = $_REQUEST["Order_Id"];
					$query1 = mysqli_query($conn, "SELECT * FROM tbl_orders WHERE `Order_Id` = '$Order_Id'") or die(mysqli_error());
					$fetch1 = mysqli_fetch_array($query1);
					?>

					<!-- Edit and Delete Buttons -->
					<div class="row">
						<div class="col-md-12 text-left">
							<?php if ($has_access_to_edit_order): ?>
								<a href="#Update_Order" id="editOrderBtn" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php endif; ?>

							<?php if ($has_access_to_delete_order): ?>
								<a href="#Delete_Order" id="deleteOrderBtn" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 text-center mt-4 position-relative">
							<div class="background-container" style="background-image: url('assets/img/cover.png');">
								<div class="col-md-12 text-center mt-4 page-title-container">
									<h1 class="text-xs font-weight-bold text-uppercase mb-1" id="packageName"></h1>
									<h5 class="text-xs font-weight-bold text-uppercase mb-1" id="orderId"></h5>
									<a href="home.php" class="breadcrumb-item" style="color: black;"><i class="fa fa-home"></i> Home</a>
									<a href="add_customers.php" class="breadcrumb-item active">Customers</a>
								</div>
							</div>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Package Description</h5>
								<p class="mx-auto" id="packageDescription"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Package Price</h5>
								<p class="mx-auto" id="packagePrice"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Customer Name</h5>
								<p class="mx-auto" id="customerName"></p>
							</h5>
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

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Order Status</h5>
								<p class="mx-auto" id="orderStatus"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4 d-none" id="reasonSection">
							<h5 class="text-xs font-weight-bold mb-1" id="reasonTitle"></h5>
							<p class="mx-auto" id="reason"></p>
						</div>

						<div class="col-md-12 text-left mt-4">
							<h5 class="page-title">
								<h5 class="tag-cloud text-xs font-weight-bold mb-1">Addon Details</h5>
							</h5>
							<br><br>
							<div class="table-responsive">
								<table class="datatable table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Addon Name</th>
											<th>Addon Description</th>
											<th>Addon Price</th>
										</tr>
									</thead>

									<tbody id="addonList">
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
		<div class="modal fade" id="Update_Order" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Update Order Status</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/updateOrder.php" id="updateOrderForm" enctype="multipart/form-data">
							<div class="row form-row">
								<div class="col-12">
									<div class="form-group">
										<input style="display:none;" type="text" name="Order_Id" class="form-control" required="" readonly="true">
										<label>Order Status</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Status" id="updateStatusSelect" class="form-control select2" required="">
											<option disabled selected>Select Order Status</option>
											<option>Pending</option>
											<option>Approved</option>
											<option>Completed</option>
											<option>Rejected</option>
											<option>Canceled</option>
										</select>
									</div>
								</div>

								<div class="col-12 d-none" id="reasonSection">
									<div class="form-group">
										<label>Reject or Canceled Reason</label><label class="text-danger">*</label>
										<textarea id="edit-text" name="Reject_Cancel_Reason" class="form-control" rows="8"></textarea>
										<p id="count-result">0/250</p>
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
		<div class="modal fade" id="Delete_Order" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="Order_Id"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteOrder.php" id="deleteOrderForm" enctype="multipart/form-data">
								<input style="display:none;" type="text" name="Order_Id" required="" readonly="true">
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

			$('#updateStatusSelect').select2();

			// GLOBAL ALERT FUNCTIONS
			function showUpdateAlerts(response) {
				$('#Update_Order').modal('hide');

				if (response.success === 'true') {
					$('#UpdateSuccessModel').modal('show');
				} else if (response.success === 'false' && response.error === 'duplicate') {
					$('#UpdateDuplicateModel').modal('show');
				} else {
					$('#UpdateFailedModel').modal('show');
				}
			}

			function showDeleteAlerts(response) {
				$('#Delete_Order').modal('hide');

				if (response.success === 'true') {
					$('#DeleteSuccessModel').modal('show');
				} else {
					$('#DeleteFailedModel').modal('show');
				}
			}

			// FUNCTION TO TOGGLE REASON FIELD BASED ON STATUS
			function toggleReasonField() {
				const status = $('#updateStatusSelect').val();
				const reasonField = $('#edit-text').closest('.col-12'); // parent div of textarea
				const reasonTextarea = $('#edit-text');

				if (status === 'Rejected' || status === 'Canceled') {
					reasonField.removeClass('d-none'); // Show field
					reasonTextarea.prop('required', false); // Make mandatory
				} else {
					reasonField.addClass('d-none'); // Hide field
					reasonTextarea.prop('required', false); // Not mandatory
					reasonTextarea.val(''); // Clear previous content
					$('#count-result').text('0 / 250'); // Reset counter
				}
			}

			// Function to fetch and display order data
			function fetchOrderData(Order_Id) {

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
					url: '../../API/Admin/viewOrderData.php',
					data: { Order_Id: Order_Id },
					dataType: 'json',
					success: function(response) {
						if (!response.orderData) {
							console.error('Failed to fetch order data');
							return;
						}

						// STATUS BADGE
						let statusBadge = '';
						const status = response.orderData.Status;
						if (status === 'Completed') statusBadge = '<span class="badge badge-primary">Completed</span>';
						else if (status === 'Pending') statusBadge = '<span class="badge badge-warning">Pending</span>';
						else if (status === 'Rejected') statusBadge = '<span class="badge badge-secondary">Rejected</span>';
						else if (status === 'Approved') statusBadge = '<span class="badge badge-info">Approved</span>';
						else if (status === 'Canceled') statusBadge = '<span class="badge badge-danger">Canceled</span>';

						$('#orderStatus').html(statusBadge);

						// Hide reason by default
						$('#reasonSection').addClass('d-none');

						// Show reason for Rejected or Canceled
						if (status === 'Rejected') {
							$('#reasonTitle').text('Reject Reason');
							$('#reason').html(response.orderData.Reject_Cancel_Reason || '-');
							$('#reasonSection').removeClass('d-none');
						} else if (status === 'Canceled') {
							$('#reasonTitle').text('Cancel Reason');
							$('#reason').html(response.orderData.Reject_Cancel_Reason || '-');
							$('#reasonSection').removeClass('d-none');
						}

						// SET ORDER DETAILS
						$('#packageDescription').text(response.orderData.Package_Name);
						$('#packagePrice').text('$' + response.orderData.Price);
						$('#packageName').text(response.orderData.Package_Name);
						$('#orderId').text(response.orderData.Order_Id);
						$('#customerName').text(response.orderData.Customer_Name);
						$('#customerContact').text(response.orderData.Customer_Contact);
						$('#customerEmail').text(response.orderData.Customer_Email);
						$('#customerAddress').html(response.orderData.Customer_Address);

						// SET CURRENT STATUS AS SELECTED
						$('#updateStatusSelect').val(status).trigger('change');

						// Trigger reason toggle for pre-selected status
						toggleReasonField();

						// EDIT BUTTON
						$('#editOrderBtn').on('click', function() {
							$('input[name="Order_Id"]').val(response.orderData.Order_Id);

							if (tinymce.get('edit-text')) {
								tinymce.get('edit-text').setContent(response.orderData.Reject_Cancel_Reason || '');
							}

							// Update character counter
							const textLength = (response.orderData.Reject_Cancel_Reason || '').replace(/<[^>]*>/g,'').length;
							$('#count-result').text(`${textLength} / 250`);
						});

						// DELETE BUTTON
						$('#deleteOrderBtn').on('click', function() {
							$('input[name="Order_Id"]').val(response.orderData.Order_Id);
							$('#Order_Id').text(response.orderData.Order_Id);
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
										let text = editor.getContent({ format: 'text' });
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

						initTinyMCE('#edit-text', '#Update_Order #count-result');

						// DATATABLE
						$('.datatable').DataTable().destroy();
						var table = $('.datatable').DataTable({
							searching: true,
							columnDefs: [{ targets: 2, className: 'text-right' }]
						});
						table.clear();

						if (response.addons.length > 0) {
							$.each(response.addons, function(index, addon) {
								const formattedAddonPrice = '$' + addon.Addon_Price;
								table.row.add([addon.Addon_Name, addon.Addon_description, formattedAddonPrice]);
							});
						} else {
							console.log('No data received.');
						}

						table.draw();
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			}

			// GET ORDER_ID FROM URL
			const urlParams = new URLSearchParams(window.location.search);
			const Order_Id = urlParams.get('Order_Id');
			fetchOrderData(Order_Id);

			// UPDATE ORDER FORM
			$('#updateOrderForm').submit(function(event) {
				event.preventDefault(); // prevent native form submission

				let status = $('#updateStatusSelect').val();
				let reasonField = tinymce.get('edit-text');
				let reasonText = reasonField ? reasonField.getContent({ format: 'text' }).trim() : '';

				// Only require reason for Rejected or Canceled
				if ((status === 'Rejected' || status === 'Canceled') && reasonText.length === 0) {
					// Hide edit modal
					$('#Update_Order').modal('hide');

					// Show empty reason modal
					$('#EmptyReason').modal('show');

					// Focus TinyMCE editor after modal is shown
					$('#EmptyReason').on('shown.bs.modal', function () {
						if (tinymce.get('edit-text')) {
							tinymce.get('edit-text').focus();
						}
					});

					return false; // stop form submission
				}

				// Trigger TinyMCE save to textarea
				tinymce.triggerSave();

				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/updateOrder.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showUpdateAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Update_Order').modal('hide');
						$('#UpdateFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});


			$('#UpdateSuccessModel #OkBtn').on('click', function() {
				window.location.href = 'orders.php';
			});

			// DELETE ORDER FORM
			$('#deleteOrderForm').submit(function(event) {
				event.preventDefault();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/deleteOrder.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showDeleteAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Delete_Order').modal('hide');
						$('#DeleteFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#DeleteSuccessModel #OkBtn').on('click', function() {
				window.location.href = 'orders.php';
			});

			// TOGGLE REASON FIELD ON STATUS CHANGE
			$('#updateStatusSelect').on('change', function() {
				toggleReasonField();
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