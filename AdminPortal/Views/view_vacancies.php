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

// Check if user has access to updateVacancy.php
$has_access_to_edit_vacancy = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 215") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_vacancy = true;
}

// Check if user has access to deleteVacancy.php
$has_access_to_delete_vacancy = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 216") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_vacancy = true;
}

// Check if user has access to viewApplication.php
$has_access_to_view_application = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 219") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_view_application = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Vacancies</title>

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
			background-color: #b72227;
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
			background: rgb(255, 255, 255);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 9999;
		}

		.loader-content {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		/* Logo fade animation */
		.loader-logo {
			width: 180px;
			height: auto;
			animation: fadePulse 1.5s infinite ease-in-out;
		}

		@keyframes fadePulse {
			0% {
				opacity: 0.4;
			}

			50% {
				opacity: 1;
			}

			100% {
				opacity: 0.4;
			}
		}

		/* Full-Screen Loader */
	</style>

</head>

<body>

	<!-- Full-Screen Loader -->
	<div id="pageLoader">
		<div class="loader-content">
			<img src="assets/img/loader.png" alt="Loading..." class="loader-logo">
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
					$Vacancy_Id = mysqli_real_escape_string($conn, $_REQUEST["Vacancy_Id"]);
					$query1 = mysqli_query($conn, "SELECT 
							v.Id, 
							v.Vacancy_Id, 
							v.Department_Id,
							v.Location_Id,
							v.Type_Id,
							d.Id,
							d.Department_Name,
							l.Id,
							l.Location_Name,
							t.Id,
							t.Job_Type
						FROM tbl_vacancies v
						JOIN tbl_departments d ON d.Id = v.Department_Id
						JOIN tbl_locations l ON l.Id = v.Location_Id
						JOIN tbl_types t ON t.Id = v.Type_Id
						WHERE v.Vacancy_Id = '$Vacancy_Id'
					") or die(mysqli_error($conn));

					$fetch1 = mysqli_fetch_assoc($query1);
					?>

					<!-- Edit and Delete Buttons -->
					<div class="row">
						<div class="col-md-12 text-left">
							<?php if ($has_access_to_edit_vacancy): ?>
								<a href="#Update_Vacancy" id="editVacancyBtn" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-primary-light"><i class="fe fe-pencil"></i> Edit</a>
							<?php endif; ?>

							<?php if ($has_access_to_delete_vacancy): ?>
								<a href="#Delete_Vacancy" id="deleteVacancyBtn" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn bg-danger-light"><i class="fe fe-trash"></i> Delete</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 text-center mt-4 position-relative">
							<div class="background-container" style="background-image: url('assets/img/cover.png');">
								<div class="col-md-12 text-center mt-4 page-title-container">
									<h1 class="text-xs font-weight-bold text-uppercase mb-1" id="jobTitle"></h1>
									<h5 class="text-xs font-weight-bold text-uppercase mb-1" id="vacancyId"></h5>
									<a href="home.php" class="breadcrumb-item" style="color: black;"><i class="fa fa-home"></i> Home</a>
									<a href="add_vacancies.php" class="breadcrumb-item active">Vacancies</a>
								</div>
							</div>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Department</h5>
								<p class="mx-auto" id="department"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Location</h5>
								<p class="mx-auto" id="location"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Job Type</h5>
								<p class="mx-auto" id="type"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Created Date</h5>
								<p class="mx-auto" id="createdDate"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Application Closing Date</h5>
								<p class="mx-auto" id="closingDate"></p>
							</h5>
						</div>

						<div class="col-md-4 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Active Status</h5>
								<p class="mx-auto" id="activeStatus"></p>
							</h5>
						</div>

						<div class="col-md-12 text-left mt-4">
							<h5 class="page-title">
								<h5 class="text-xs font-weight-bold mb-1">Job Description</h5>
								<p class="mx-auto" id="jobDescription"></p>
							</h5>
						</div>

						<div class="col-md-12 text-left mt-4">
							<h5 class="page-title">
								<h5 class="tag-cloud text-xs font-weight-bold mb-1">Applicant Details</h5>
							</h5>
							<br><br>
							<div class="table-responsive">
								<table class="datatable table table-hover table-center mb-0">
									<thead>
										<tr>
											<th>Application No</th>
											<th>Name of Applicant</th>
											<th>Process Status</th>
											<th>Address of Applicant</th>
											<th>Contact No. of Applicant</th>
											<th>Email Address of Applicant</th>
											<?php if ($has_access_to_view_application): ?>
												<th>Action</th>
											<?php else: ?>
												<th style="display:none;">Action</th>
											<?php endif; ?>

										</tr>
									</thead>

									<tbody id="applicantList">
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
		<div class="modal fade" id="Update_Vacancy" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Update Vacancy</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<form method="POST" action="../../API/Admin/updateVacancy.php" id="updateVacancyForm" enctype="multipart/form-data">
							<div class="row form-row">

								<?php

								require_once '../Controllers/select_controller.php';

								$db_handle = new DBController();
								$departmentResult = $db_handle->runQuery("SELECT * FROM tbl_departments ORDER BY Id ASC");
								$locationResult = $db_handle->runQuery("SELECT * FROM tbl_locations ORDER BY Id ASC");
								$typeResult = $db_handle->runQuery("SELECT * FROM tbl_types ORDER BY Id ASC");
								?>

								<div class="col-12">
									<div class="form-group">
										<label>Job Title</label><label class="text-danger">*</label>
										<input style="display:none;" type="text" name="Vacancy_Id" class="form-control" required="" readonly="true">
										<input style="display:none;" type="text" name="Is_Active" class="form-control" required="" readonly="true">
										<input type="text" name="Job_Title" class="form-control" required="">
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Department</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Department_Id" id="departmentSelect" class="form-control" required="">
											<option disabled>Select Department</option>
											<?php
											if (!empty($departmentResult)) {
												foreach ($departmentResult as $key => $value) {
													$selected = ($departmentResult[$key]['Id'] == $fetch1['Department_Id']) ? 'selected' : '';
													echo '<option value="' . $departmentResult[$key]['Id'] . '" ' . $selected . '>' . $departmentResult[$key]['Department_Name'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Location</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Location_Id" id="locationSelect" class="form-control" required="">
											<option disabled>Select Location</option>
											<?php
											if (!empty($locationResult)) {
												foreach ($locationResult as $key => $value) {
													$selected = ($locationResult[$key]['Id'] == $fetch1['Location_Id']) ? 'selected' : '';
													echo '<option value="' . $locationResult[$key]['Id'] . '" ' . $selected . '>' . $locationResult[$key]['Location_Name'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Job Type</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Type_Id" id="typeSelect" class="form-control" required="">
											<option disabled>Select Job Type</option>
											<?php
											if (!empty($typeResult)) {
												foreach ($typeResult as $key => $value) {
													$selected = ($typeResult[$key]['Id'] == $fetch1['Type_Id']) ? 'selected' : '';
													echo '<option value="' . $typeResult[$key]['Id'] . '" ' . $selected . '>' . $typeResult[$key]['Job_Type'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Application Closing Date</label><label class="text-danger">*</label>
										<input type="datetime-local" name="Closing_Date" class="form-control" required="">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Job Description</label><label class="text-danger">*</label>
										<textarea id="edit-text" name="Job_Description" class="form-control" rows="8" placeholder="Enter Description . . ."></textarea>
										<p id="count-result">0/2500</p>
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
		<div class="modal fade" id="Delete_Vacancy" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="Vacancy_Id"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteVacancy.php" id="deleteVacancyForm" enctype="multipart/form-data">
								<input style="display:none;" type="text" name="Vacancy_Id" required="" readonly="true">
								<button type="submit" name="delete" class="btn btn-primary btn-block">Delete </button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Delete Modal -->

		<!-- View Model -->
		<div id="applicationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; overflow:auto;">
			<div style="max-width:650px; margin:50px auto; background:#fff; border-radius:8px; position:relative;">

				<!-- CLOSE BUTTON -->
				<span onclick="closeModal()"
					style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px;">&times;</span>

				<!-- CONTENT WILL LOAD HERE -->
				<div id="modalContent"></div>

			</div>
		</div>
		<!-- View Model -->

		<!-- Update Modal -->
		<div class="modal fade" id="Update_Application_Status">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="POST" action="../../API/Admin/updateApplicationStatus.php" id="updateApplicationStatusForm" enctype="multipart/form-data">
						<div class="modal-header">
							<h5 class="modal-title">Update Application Status</h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="Application_Id">
							<input type="hidden" name="Status">
							<p>Are you sure you want to change status to
								<b id="updateStatusText"></b> ?
							</p>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-block">Update Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Update Modal -->

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

				$('#departmentSelect').select2();
				$('#locationSelect').select2();
				$('#typeSelect').select2();

				// GLOBAL ALERT FUNCTIONS
				function showUpdateAlerts(response) {
					$('#Update_Vacancy').modal('hide');
					$('#Update_Application_Status').modal('hide');

					if (response.success === 'true') {
						$('#UpdateSuccessModel').modal('show');
					} else if (response.success === 'false' && response.error === 'duplicate') {
						$('#UpdateDuplicateModel').modal('show');
					} else {
						$('#UpdateFailedModel').modal('show');
					}
				}

				function showDeleteAlerts(response) {
					$('#Delete_Vacancy').modal('hide');

					if (response.success === 'true') {
						$('#DeleteSuccessModel').modal('show');
					} else {
						$('#DeleteFailedModel').modal('show');
					}
				}

				// Function to fetch and display vacancy data
				function fetchVacancyData(Vacancy_Id) {

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
						url: '../../API/Admin/viewVacancyData.php',
						data: {
							Vacancy_Id: Vacancy_Id
						},
						dataType: 'json',
						success: function(response) {
							if (!response.vacancyData) {
								console.error('Failed to fetch job data');
								return;
							}

							let jobType = `<span class="badge badge-secondary">${response.vacancyData.Job_Type}</span>`;

							// ACTIVE BADGE
							let activeStatus = '';
							const IsActive = response.vacancyData.Is_Active;
							if (IsActive === '1') activeStatus = '<span class="badge badge-primary">Active</span>';
							else if (IsActive === '0') activeStatus = '<span class="badge  badge-danger">In Active</span>';

							// SET ORDER DETAILS
							$('#jobTitle').text(response.vacancyData.Job_Title);
							$('#vacancyId').text(response.vacancyData.Vacancy_Id);
							$('#department').text(response.vacancyData.Department_Name);
							$('#location').text(response.vacancyData.Location_Name);
							$('#type').html(jobType);
							$('#createdDate').html(response.vacancyData.Created_Date);
							$('#closingDate').html(response.vacancyData.Closing_Date);
							$('#activeStatus').html(activeStatus);
							$('#jobDescription').html(response.vacancyData.Job_Description);

							$('#editVacancyBtn').on('click', function() {

								$('input[name="Vacancy_Id"]').val($('#vacancyId').text());
								$('input[name="Job_Title"]').val($('#jobTitle').text());
								$('input[name="Is_Active"]').val(response.vacancyData.Is_Active);
								$('input[name="Closing_Date"]').val(response.vacancyData.Closing_Date);
								tinymce.get('edit-text').setContent(response.vacancyData.Job_Description);

							});

							// DELETE BUTTON
							$('#deleteVacancyBtn').on('click', function() {
								$('input[name="Vacancy_Id"]').val(response.vacancyData.Vacancy_Id);
								$('#Vacancy_Id').text(response.vacancyData.Vacancy_Id);
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
										const limit = 250;
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

							initTinyMCE('#edit-text', '#count-result');

							// DATATABLE
							$('.datatable').DataTable().destroy();
							var table = $('.datatable').DataTable({
								searching: true,
								columnDefs: [{
										targets: 2,
										className: 'text-center'
									},
									{
										targets: 6,
										className: 'text-center'
									}
								]
							});

							table.clear();

							if (response.applications.length > 0) {
								$.each(response.applications, function(index, application) {

									var hasAccessToViewApplication = <?php echo json_encode($has_access_to_view_application); ?>;

									if (!hasAccessToViewApplication) {
										table.column(6).visible(false);
									}

									let Status = '';
									const applicationStatus = application.status;
									if (applicationStatus === 'Hired') Status = '<span class="badge badge-primary">Hired</span>';
									else if (applicationStatus === 'Rejected') Status = '<span class="badge badge-danger">Rejected</span>';
									else if (applicationStatus === 'Pending') Status = '<span class="badge badge-warning">Pending</span>';
									else if (applicationStatus === 'Sort Listed') Status = '<span class="badge badge-secondary">Sort Listed</span>';
									else if (applicationStatus === 'Interview') Status = '<span class="badge badge-info">Interview</span>';

									let actions = '';
									if (hasAccessToViewApplication) {

										actions = `
											<div class="actions">
												<a class="btn btn-sm bg-success-light view-btn" href="javascript:void(0);" data-id="${application.Application_Id}"><i class="fe fe-eye"></i> View</a>
											</div>
										`;

									} else {
										actions = `
											<div class="actions" style="display:none;">
												<a class="btn btn-sm bg-success-light" href="#"><i class="fe fe-eye"></i> View</a>
											</div>`;
									}

									table.row.add([
										application.Application_Id,
										application.Applicant_Name,
										Status,
										application.Applicant_Address,
										application.Applicant_Contact,
										application.Applicant_Email,
										actions
									]);
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

				// GET VACANCY_ID FROM URL
				const urlParams = new URLSearchParams(window.location.search);
				const Vacancy_Id = urlParams.get('Vacancy_Id');
				fetchVacancyData(Vacancy_Id);

				$('#updateVacancyForm').submit(function(e) {
					e.preventDefault();

					// Get TinyMCE content
					let descriptionText = tinymce.get('edit-text').getContent({
						format: 'text'
					}).trim();

					// Validation
					if (!descriptionText.length) {
						$('#Update_Vacancy').modal('hide');
						$('#UpdateFailedModel').modal('show');
						tinymce.get('edit-text').focus();
						return false;
					}

					// Save TinyMCE content to textarea
					tinymce.triggerSave();

					$('#pageLoader').show();

					$.ajax({
						type: 'POST',
						url: '../../API/Admin/updateVacancy.php',
						data: $(this).serialize(),
						success: function(response) {

							if (typeof response === 'string') {
								response = JSON.parse(response);
							}

							$('#Update_Vacancy').modal('hide');

							if (response.success === 'true') {
								$('#UpdateSuccessModel').modal('show');
							} else if (response.success === 'false' && response.error === 'duplicate') {
								$('#UpdateDuplicateModel').modal('show');
							} else {
								$('#UpdateFailedModel').modal('show');
							}

							console.log(response);
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
							$('#Update_Vacancy').modal('hide');
							$('#UpdateFailedModel').modal('show');
						},
						complete: function() {
							$('#pageLoader').hide();
						}
					});
				});

				$('#UpdateSuccessModel #OkBtn').click(function() {
					window.location.href = 'add_vacancies.php';
				});

				// DELETE VACANCY FORM
				$('#deleteVacancyForm').submit(function(event) {
					event.preventDefault();
					$('#pageLoader').show();

					$.ajax({
						type: 'POST',
						url: '../../API/Admin/deleteVacancy.php',
						data: $(this).serialize(),
						success: function(response) {
							if (typeof response === 'string') response = JSON.parse(response);
							showDeleteAlerts(response);
							console.log(response);
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
							$('#Delete_Vacancy').modal('hide');
							$('#DeleteFailedModel').modal('show');
						},
						complete: function() {
							$('#pageLoader').hide();
						}
					});
				});

				$('#DeleteSuccessModel #OkBtn').on('click', function() {
					window.location.href = 'add_vacancies.php';
				});

				// ===============================
				// UPDATE STATUS SUBMIT
				// ===============================
				$('#updateApplicationStatusForm').submit(function(e) {
					e.preventDefault()
					$('#pageLoader').show()

					$.ajax({
						type: 'POST',
						url: '../../API/Admin/updateApplicationStatus.php',
						data: $(this).serialize(),
						success: function(response) {
							if (typeof response === 'string') response = JSON.parse(response);
							showUpdateAlerts(response);
							console.log(response);
						},
						error: function(xhr, status, error) {
							console.error('Error:', status, error);
							$('#Update_Application_Status').modal('hide');
							$('#UpdateFailedModel').modal('show');
						},
						complete: function() {
							$('#pageLoader').hide();
						}
					})
				});

				$('#UpdateSuccessModel #OkBtn').click(function() {
					window.location.href = 'add_vacancies.php';
				});

			});

			$(document).on("click", ".view-btn", function() {
				let applicationId = $(this).data("id");

				$.ajax({
					type: "POST",
					url: "../../API/Admin/viewApplication.php",
					data: {
						Application_Id: applicationId
					},
					success: function(response) {

						let data = (typeof response === "string") ? JSON.parse(response) : response;

						if (data.success === "true") {

							let statusBadge = '';
							if (data.Status === 'Pending') statusBadge = '<span class="badge badge-warning">Pending</span>';
							else if (data.Status === 'Hired') statusBadge = '<span class="badge badge-primary">Hired</span>';
							else if (data.Status === 'Rejected') statusBadge = '<span class="badge badge-danger">Rejected</span>';
							else if (data.Status === 'Interview') statusBadge = '<span class="badge badge-info">Interview</span>';
							else statusBadge = `<span class="badge badge-secondary">${data.Status}</span>`;

							let actionButtons = '';

							if (data.Status === 'Pending') {
								actionButtons = `
								<button class="btn btn-secondary update-status" data-status="Sort Listed" data-id="${data.Application_Id}">Sort List</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Application_Id}">Reject</button>
							`;
							} else if (data.Status === 'Sort Listed') {
								actionButtons = `
								<button class="btn btn-warning update-status" data-status="Pending" data-id="${data.Application_Id}">Pending</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Application_Id}">Reject</button>
								<button class="btn btn-info update-status ml-2" data-status="Interview" data-id="${data.Application_Id}">Interview</button>
							`;
							} else if (data.Status === 'Interview') {
								actionButtons = `
								<button class="btn btn-warning update-status" data-status="Pending" data-id="${data.Application_Id}">Pending</button>
								<button class="btn btn-primary update-status ml-2" data-status="Hired" data-id="${data.Application_Id}">Hired</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Application_Id}">Reject</button>	
							`;
							} else {
								actionButtons = ''; // Rejected & Hired → no buttons
							}

							let html = `
						<div class="application-card" style="font-family: Arial, sans-serif; background-color:#f6f6f6; padding:30px;">
							<table width="100%" style="max-width:600px; margin:auto; background:#fff; border-radius:8px;">

								<tr>
									<td style="padding:20px;text-align:center;">
										<img src="assets/img/logo.png">
									</td>
								</tr>

								<tr>
									<td style="padding:30px;">
										<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">
			
											<!-- LEFT: STATUS -->
											<p style="margin:0;"><b>Process Status: </b>${statusBadge}</p>

											<!-- RIGHT: ACTION BUTTONS -->
											<div>
												${actionButtons}
											</div>

										</div>

										<table width="100%" cellpadding="8" style="margin-top:20px;">
											<tr style="background:#f2f2f2;">
												<td colspan="2"><b>Applicant Details</b></td>
											</tr>
											<tr>
												<td><b>Application No</b></td>
												<td>${data.Application_Id}</td>
											</tr>
											<tr>
												<td><b>Job Title</b></td>
												<td>${data.Job_Title}</td>
											</tr>
											<tr>
												<td><b>Job Location</b></td>
												<td>${data.Job_Location}</td>
											</tr>
											<tr>
												<td><b>Job Type</b></td>
												<td>${data.Job_Type}</td>
											</tr>
											<tr>
												<td><b>Applicant Name</b></td>
												<td>${data.Applicant_Name}</td>
											</tr>
											<tr>
												<td><b>Applicant Address</b></td>
												<td>${data.Applicant_Address}</td>
											</tr>
											<tr>
												<td><b>Applicant Contact</b></td>
												<td>${data.Applicant_Contact}</td>
											</tr>
											<tr>
												<td><b>Applicant Email</b></td>
												<td>${data.Applicant_Email}</td>
											</tr>
										</table>

										<!-- DOWNLOAD BUTTON -->
										<div style="text-align:center; margin-top:20px;">
											<a href="${data.cvPdfUrl}" download
											style="padding:10px 20px; background:#b72227; color:#fff; text-decoration:none; border-radius:5px;"><i class="fe fe-download"></i>
												Download CV
											</a>
										</div>
									</td>
								</tr>
							</table>
						</div>
						`;

							$("#modalContent").html(html);
							$("#applicationModal").fadeIn();
						}
					}
				});
			});

			$(document).on('click', '.update-status', function() {

				const Id = $(this).data('id')
				const status = $(this).data('status')

				$('#Update_Application_Status input[name="Application_Id"]').val(Id);
				$('#Update_Application_Status input[name="Status"]').val(status);

				$('#applicationModal').fadeOut();

				$('#updateStatusText').text(status);
				$('#Update_Application_Status').modal('show');
			});

			function closeModal() {
				$("#applicationModal").fadeOut();
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

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:51 GMT -->

</html>