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

// Check if user has access to addNewVacancy.php
$has_access_to_add_vacancy = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 213") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_add_vacancy = true;
}

// Check if user has access to activeVacancy.php
$has_access_to_edit_status= false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 218") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_status = true;
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

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">Vacancies</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Vacancies</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							<?php if ($has_access_to_add_vacancy): ?>
								<a href="#Add_Vacancy" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i
										class="fa fa-plus-square" aria-hidden="true"></i> Add New Vacancy</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal"
									class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square"
										aria-hidden="true"></i> Add New Vacancy</a>
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
												<th>ID</th>
												<th>Job Title</th>
												<th>Department</th>
												<th>Location</th>
												<th>Job Type</th>
												<th>Is Active</th>
												<th>Created Date</th>
												<th>Closing Date</th>
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
		<div class="modal fade" id="Add_Vacancy" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Vacancy</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/addNewVacancy.php" id="addVacancyForm" enctype="multipart/form-data">
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
										<input type="text" name="Job_Title" class="form-control" required="">
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Department</label><label class="text-danger">*</label>
										<select style="width:100%;" name="Department_Id" id="departmentSelect" class="form-control" required="">
											<option selected disabled>Select Department</option>
											<?php
											if (! empty($departmentResult)) {
												foreach ($departmentResult as $key => $value) {
													echo '<option value="' . $departmentResult[$key]['Id'] . '">' . $departmentResult[$key]['Department_Name'] . '</option>';
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
											<option selected disabled>Select Location</option>
											<?php
											if (! empty($locationResult)) {
												foreach ($locationResult as $key => $value) {
													echo '<option value="' . $locationResult[$key]['Id'] . '">' . $locationResult[$key]['Location_Name'] . '</option>';
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
											<option selected disabled>Select Job Type</option>
											<?php
											if (! empty($typeResult)) {
												foreach ($typeResult as $key => $value) {
													echo '<option value="' . $typeResult[$key]['Id'] . '">' . $typeResult[$key]['Job_Type'] . '</option>';
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
										<textarea id="add-text" name="Job_Description" class="form-control" rows="8" placeholder="Enter Description . . ."></textarea>
										<p id="count-result">0/2500</p>
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
	<script src="https://cdn.tiny.cloud/1/9lf9h735jucnqfgf4ugu8egij1icgzsrgbcmsk5tg44cjba8/tinymce/8/tinymce.min.js"
		referrerpolicy="origin" crossorigin="anonymous"></script>

	<script>
		// GLOBAL ALERT FUNCTIONS
		function showSaveAlerts(response) {
			$('#Add_Vacancy').modal('hide');

			if (response.success === 'true') {
				$('#SaveSuccessModel').modal('show');
			} else if (response.success === 'false' && response.error === 'duplicate') {
				$('#SaveDuplicateModel').modal('show');
			} else {
				$('#SaveFailedModel').modal('show');
			}
		}

		// DOCUMENT READY
		$(document).ready(function () {
			// PAGE LOADER
			let startTime = performance.now();
			window.addEventListener("load", function () {
				let endTime = performance.now();
				let loadTime = endTime - startTime;
				let delay = Math.max(loadTime);
				setTimeout(function () {
					$("#pageLoader").hide();
				}, delay);
			});

			$('#departmentSelect').select2();
			$('#locationSelect').select2();
			$('#typeSelect').select2();

			// DATA TABLE FETCH
			$.ajax({
				type: 'POST',
				url: '../../API/Admin/getAllVacancyData.php',
				dataType: 'json',
				success: function (data) {
					if (data.length > 0) {

						const canEdit = <?php echo $has_access_to_edit_status ? 'true' : 'false'; ?>;
						$('.datatable').DataTable().destroy();

						var table = $('.datatable').DataTable({
							searching: true, // Enable search
							columnDefs:
								[
									{
										targets: 4,
										className: 'text-center'
									},
									{
										targets: 8,
										className: 'text-center'
									}
								]
						});

						// Clear existing rows
						table.clear();

						$.each(data, function (index, row) {

							const toggleId = `status_${row.Vacancy_Id}`;
							let jobType = `<span class="badge badge-secondary">${row.Job_Type}</span>`;

							const statusToggle = canEdit ?
								`
									<div class="status-toggle">
										<input type="checkbox"
											id="${toggleId}"
											class="check"
											${row.Is_Active === "1" ? "checked" : ""}
											data-id="${row.Vacancy_Id}">
										<label for="${toggleId}" class="checktoggle">checkbox</label>
									</div>
								` :
								'';

							table.row.add([
								row.Vacancy_Id,
								row.Job_Title,
								row.Department_Name,
								row.Location_Name,
								jobType,
								statusToggle,
								row.Created_Date,
								row.Closing_Date,
								'<div class="actions"><a class="btn btn-sm bg-success-light" href="view_role.php?Role_Id=' + row.Vacancy_Id + '"><i class="fe fe-eye"></i> View </a></div>'
							]);
						});

						// Draw the table
						table.draw();

						if (!canEdit) {
							table.column(5).visible(false); // Hide "Is Active"
						}

					} else {
						console.log('No data received.');
					}
				},
				error: function (xhr, status, error) {
					console.error('Error:', status, error);
				}
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
						const limit = 2500;
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

			initTinyMCE('#add-text', '#Add_Vacancy #count-result');

			// ADD VACANCY
			$('#addVacancyForm').submit(function(e) {
				e.preventDefault();
				let descriptionText = tinymce.get('add-text').getContent({
					format: 'text'
				}).trim();

				if (!descriptionText.length) {
					$('#Add_Vacancy').modal('hide');
					$('#EmptyDescription').modal('show');
					tinymce.get('add-text').focus();
					return false;
				}

				tinymce.triggerSave();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/addNewVacancy.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showSaveAlerts(response);
					},
					error: function() {
						$('#Add_Vacancy').modal('hide');
						$('#SaveFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#SaveSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_vacancies.php';
			});
		});

		$(document).on('change', '.status-toggle .check', function() {

		const checkbox = $(this);
		const Vacancy_Id = checkbox.data('id');
		const Is_Active = checkbox.is(':checked') ? 1 : 0;

		$('#pageLoader').show();

			$.ajax({
				type: 'POST',
				url: '../../API/Admin/activeVacancy.php',
				data: {
					Vacancy_Id: Vacancy_Id,
					Is_Active: Is_Active
				},
				dataType: 'json',
				success: function(response) {

					if (response.success !== 'true') {
						// Revert toggle if failed
						checkbox.prop('checked', !checkbox.is(':checked'));
						$('#UpdateFailedModel').modal('show');
					}
				},
				error: function() {
					// Revert toggle on error
					checkbox.prop('checked', !checkbox.is(':checked'));
					$('#UpdateFailedModel').modal('show');
				},
				complete: function() {
					$('#pageLoader').hide();
				}
			});
		});
	</script>

	<!-- Loader Script -->
	<script>
		let startTime = performance.now(); // Capture the start time when the page starts loading

		window.addEventListener("load", function () {
			let endTime = performance.now(); // Capture the end time when the page is fully loaded
			let loadTime = endTime - startTime; // Calculate the total loading time

			// Ensure the loader stays for at least 500ms but disappears dynamically based on actual load time
			let delay = Math.max(loadTime);

			setTimeout(function () {
				document.getElementById("pageLoader").style.display = "none";
			}, delay);
		});
	</script>
	<!-- /Loader Script -->

</body>

</html>