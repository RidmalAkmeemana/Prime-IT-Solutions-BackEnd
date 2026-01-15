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

// Check if user has access to addNewUser.php
$has_access_to_add_user = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 132") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_add_user = true;
}

// Check if user has access to updateUser.php
$has_access_to_edit_user = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 134") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_user = true;
}

// Check if user has access to deleteUser.php
$has_access_to_delete_user = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 135") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_user = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Users</title>

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
							<h3 class="page-title">Users</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Users</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							<?php if ($has_access_to_add_user): ?>
								<a href="#Add_User" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New User</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New User</a>
							<?php endif; ?>
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
												<th>Name of Users</th>
												<th>Role</th>
												<th>Username</th>
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


		<!-- Add Modal -->
		<div class="modal fade" id="Add_User" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add User</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/addNewUser.php" id="addUserForm" enctype="multipart/form-data">
							<div class="row form-row">

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>First Name</label><label class="text-danger">*</label>
										<input type="text" name="First_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Last Name</label><label class="text-danger">*</label>
										<input type="text" name="Last_Name" class="form-control" required="">
									</div>
								</div>

								<?php

								require_once '../Controllers/select_controller.php';

								$db_handle = new DBController();
								$countryResult = $db_handle->runQuery("SELECT * FROM tbl_roles ORDER BY Role_Id ASC");
								?>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Username</label><label class="text-danger">*</label>
										<input type="text" name="Username" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Password</label><label class="text-danger">*</label>
										<input type="password" name="Password" class="form-control" required="">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Role Name</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Status" id="roleSelect" class="form-control" required="">
											<option selected disabled>Select Role Name</option>
											<?php
											if (! empty($countryResult)) {
												foreach ($countryResult as $key => $value) {
													echo '<option value="' . $countryResult[$key]['Role_Name'] . '">' . $countryResult[$key]['Role_Name'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

							</div>
							<button type="submit" name="save" class="btn btn-primary btn-block">Save Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Modal -->

		<!-- Edit Details Modal-->
		<div class="modal fade" id="Update_User" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit User Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/updateUser.php" id="updateUserForm" enctype="multipart/form-data">
							<div class="row form-row">

								<?php

								require_once '../Controllers/select_controller.php';

								$db_handle = new DBController();
								$countryResult = $db_handle->runQuery("SELECT * FROM tbl_roles ORDER BY Role_Id ASC");
								?>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>First Name</label><label class="text-danger">*</label>
										<input style="display:none;" type="text" name="Id" class="form-control" required="" readonly="true">
										<input type="text" name="First_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Last Name</label><label class="text-danger">*</label>
										<input type="text" name="Last_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Username</label><label class="text-danger">*</label>
										<input type="text" name="Username" class="form-control" required="">
									</div>
								</div>

								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Password</label><label class="text-danger"></label>
										<input type="password" name="Password" class="form-control">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Role Name</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Status" id="updateRoleSelect" class="form-control select2" required="">
											<option disabled selected>Select Role Name</option>
											<?php
											if (!empty($countryResult)) {
												foreach ($countryResult as $role) {
													echo '<option value="' . htmlspecialchars($role['Role_Name']) . '">' . htmlspecialchars($role['Role_Name']) . '</option>';
												}
											}
											?>
										</select>
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
		<div class="modal fade" id="Delete_User" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="deleteUserName"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteUser.php" id="deleteUserForm" enctype="multipart/form-data">
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

	<script>
		// GLOBAL ALERT FUNCTIONS
		function showSaveAlerts(response) {
			$('#Add_User').modal('hide');

			if (response.success === 'true') {
				$('#SaveSuccessModel').modal('show');
			} else if (response.success === 'false' && response.error === 'duplicate') {
				$('#SaveDuplicateModel').modal('show');
			} else {
				$('#SaveFailedModel').modal('show');
			}
		}

		function showUpdateAlerts(response) {
			$('#Update_User').modal('hide');

			if (response.success === 'true') {
				$('#UpdateSuccessModel').modal('show');
			} else if (response.success === 'false' && response.error === 'duplicate') {
				$('#UpdateDuplicateModel').modal('show');
			} else {
				$('#UpdateFailedModel').modal('show');
			}
		}

		function showDeleteAlerts(response) {
			$('#Delete_User').modal('hide');

			if (response.success === 'true') {
				$('#DeleteSuccessModel').modal('show');
			} else {
				$('#DeleteFailedModel').modal('show');
			}
		}

		// DOCUMENT READY
		$(document).ready(function() {

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

			$('#roleSelect').select2();
			$('#updateRoleSelect').select2();

			// Make an AJAX request to getAllUserData.php
			$.ajax({
				type: 'POST',
				url: '../../API/Admin/getAllUserData.php',
				dataType: 'json',
				success: function(data) {
					if (data.length > 0) {
						// Destroy existing DataTable, if any
						$('.datatable').DataTable().destroy();

						var table = $('.datatable').DataTable({
							searching: true, // Enable search
							columnDefs: 
							[
								{
									targets: 4,
									className: 'text-center'
								}
							]
						});

						// Clear existing rows
						table.clear();

						$.each(data, function(index, row) {

							const canEdit = <?php echo $has_access_to_edit_user ? 'true' : 'false'; ?>;
							const canDelete = <?php echo $has_access_to_delete_user ? 'true' : 'false'; ?>;

							let actionButtons = `<div class="actions">`;

							if (canEdit) {
								actionButtons += `
                                <a href="javascript:void(0);"
                                class="btn btn-sm bg-primary-light ms-1 edit-user-btn"
                                data-id="${row.id}"
                                data-firstname="${row.firstname}"
								data-lastname="${row.lastname}"
                                data-status="${row.status}"
                                data-username="${row.username}">
                                    <i class="fe fe-pencil"></i> Edit
                                </a>`;
							}

							if (canDelete) {
								actionButtons += `
                                <a href="javascript:void(0);"
                                class="btn btn-sm bg-danger-light ms-1 delete-user-btn"
                                data-id="${row.id}"
                                data-firstname="${row.firstname}"
								data-lastname="${row.lastname}">
                                    <i class="fe fe-trash"></i> Delete
                                </a>`;
							}

							actionButtons += `</div>`;

							table.row.add([
								row.id,
								'<a href="' + row.img + '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' + row.img + '" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;"></a>' + row.firstname + ' ' + row.lastname,
								row.status,
								row.username,
								actionButtons
							]);
						});

						// After table initialization, hide the column if all actionButtons are empty
						if (!<?php echo ($has_access_to_edit_user || $has_access_to_delete_user) ? 'true' : 'false'; ?>) {
							$('.datatable').DataTable().column(4).visible(false); // Hide Actions column
						}

						// Draw the table
						table.draw();

					} else {
						console.log('No data received.');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', status, error);
				}
			});

			// ADD USER
			$('#addUserForm').submit(function(event) {

				event.preventDefault();

				$('#pageLoader').show(); // Show loader before sending

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/addNewUser.php',
					data: $(this).serialize(),
					success: function(response) {
						// Parse the response as a JSON object (if not already parsed)
						if (typeof response === 'string') {
							response = JSON.parse(response);
						}

						// Show the appropriate modal based on response
						showSaveAlerts(response);

						// Log the response for debugging
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						// Hide the Add Supplier modal in case of any AJAX errors and show failure modal
						$('#Add_User').modal('hide');
						$('#SaveFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide(); // Hide loader after response (success or error)
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
					}
				});
			});

			// Handle the "Ok" button click in the SaveSuccessModel
			$('#SaveSuccessModel #OkBtn').on('click', function() {
				// Refresh the page when "Ok" is clicked
				window.location.href = 'add_users.php';
			});

			// EDIT USER
			$(document).on('click', '.edit-user-btn', function() {
				const Id = $(this).data('id');
				const firstName = $(this).data('firstname');
				const lastName = $(this).data('lastname');
				const Username = $(this).data('username');
				const Status = $(this).data('status');

				$('#Update_User input[name="Id"]').val(Id);
				$('#Update_User input[name="First_Name"]').val(firstName);
				$('#Update_User input[name="Last_Name"]').val(lastName);
				$('#Update_User input[name="Username"]').val(Username);
				$('#Update_User select[name="Status"]').val(Status).trigger('change');

				$('#Update_User').modal('show');
			});

			$('#updateUserForm').submit(function(e) {
				e.preventDefault();

				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/updateUser.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showUpdateAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Update_User').modal('hide');
						$('#UpdateFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#UpdateSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_users.php';
			});

			// DELETE USER
			$(document).on('click', '.delete-user-btn', function() {
				const Id = $(this).data('id');
				const fullName = `${$(this).data('firstname')} ${$(this).data('lastname')}`;

				$('#Delete_User input[name="Id"]').val(Id);
				$('#deleteUserName').text(fullName);
				$('#Delete_User').modal('show');
			});

			$('#deleteUserForm').submit(function(e) {
				e.preventDefault();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/deleteUser.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showDeleteAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Delete_User').modal('hide');
						$('#DeleteFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#DeleteSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_users.php';
			});

			// CURRENCY INPUT VALIDATION
			$(document).on('input', '.currency-input', function() {
				let enteredValue = parseFloat($(this).val());
				if (isNaN(enteredValue) || enteredValue < 0) {
					$(this).val('');
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