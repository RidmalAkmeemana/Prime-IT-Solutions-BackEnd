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

// Check if user has access to deleteApplication.php
$has_access_to_delete_application = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 226") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_application = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Individuals</title>

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
							<h3 class="page-title">Individuals</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Individuals</li>
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
												<th>Application Id</th>
												<th>Job Title</th>
												<th>Applicant Name</th>
												<th>Status</th>
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
		<div class="modal fade" id="Delete_Application" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="deleteApplicationName"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteApplication.php" id="deleteApplicationForm" enctype="multipart/form-data">
								<input style="display: none;" type="text" name="Id" required="" readonly="true">
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
					<form method="POST" action="../../API/Admin/updateIndividualStatus.php" id="updateIndividualStatusForm" enctype="multipart/form-data">
						<div class="modal-header">
							<h5 class="modal-title">Update Application Status</h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<input type="hidden" name="Individuals_Id">
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
		function showUpdateAlerts(response) {
			$('#Update_Application_Status').modal('hide');

			if (response.success === 'true') {
				$('#UpdateSuccessModel').modal('show');
			} else {
				$('#UpdateFailedModel').modal('show');
			}
		}

		function showDeleteAlerts(response) {
			$('#Delete_Application').modal('hide');

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

			// DATA TABLE FETCH
			$.ajax({
				type: 'POST',
				url: '../../API/Admin/getAllIndividualData.php',
				dataType: 'json',
				success: function(data) {
					if (data.length > 0) {
						$('.datatable').DataTable().destroy();

						var table = $('.datatable').DataTable({
							searching: true,
							columnDefs: [{
								targets: 4,
								className: 'text-center'
							}]
						});

						table.clear();

						$.each(data, function(index, row) {
							const canDelete = <?php echo $has_access_to_delete_application ? 'true' : 'false'; ?>;

							let actionButtons = `<div class="actions">`;

							actionButtons += `<div class="actions">
								<a class="btn btn-sm bg-success-light view-btn" href="javascript:void(0);" data-id="${row.Individuals_Id}"><i class="fe fe-eye"></i> View</a>`;

							if (canDelete) {
								actionButtons += `
                                <a href="javascript:void(0);"
                                class="btn btn-sm bg-danger-light ms-1 delete-application-btn"
                                data-id="${row.Individuals_Id}">
                                    <i class="fe fe-trash"></i> Delete
                                </a>`;
							}

							actionButtons += `</div>`;

							let Status = '';
							const applicationStatus = row.Status;
							if (applicationStatus === 'Hired') Status = '<span class="badge badge-primary">Hired</span>';
							else if (applicationStatus === 'Rejected') Status = '<span class="badge badge-danger">Rejected</span>';
							else if (applicationStatus === 'Pending') Status = '<span class="badge badge-warning">Pending</span>';
							else if (applicationStatus === 'Sort Listed') Status = '<span class="badge badge-secondary">Sort Listed</span>';
							else if (applicationStatus === 'Interview') Status = '<span class="badge badge-info">Interview</span>';

							table.row.add([
								row.Individuals_Id,
								row.Job_Title,
								row.Applicant_Name,
								Status,
								actionButtons
							]);
						});

						table.draw();
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching applicant:', status, error);
				}
			});

			// DELETE APPLICANT
			$(document).on('click', '.delete-application-btn', function() {
				const Id = $(this).data('id');

				$('#Delete_Application input[name="Id"]').val(Id);
				$('#deleteApplicationName').text(Id);
				$('#Delete_Application').modal('show');
			});

			$('#deleteApplicationForm').submit(function(e) {
				e.preventDefault();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/deleteIndividual.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showDeleteAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Delete_Application').modal('hide');
						$('#DeleteFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#DeleteSuccessModel #OkBtn').click(function() {
				window.location.href = 'view_individuals.php';
			});

			// ===============================
			// UPDATE STATUS SUBMIT
			// ===============================
			$('#updateIndividualStatusForm').submit(function(e) {
				e.preventDefault()
				$('#pageLoader').show()

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/updateIndividualStatus.php',
					data: $(this).serialize(),
					success: function(response) {

						if (typeof response === 'string') response = JSON.parse(response);
						showUpdateAlerts(response);
						console.log(response);

						if (response.success == true || response.success === 'true') {

							const appId = $('#updateIndividualStatusForm input[name="Individuals_Id"]').val();
							const status = $('#updateIndividualStatusForm input[name="Status"]').val();

							// STATUS-WISE MESSAGE
							let statusMessage = '';
							switch (status) {
								case 'Pending':
									statusMessage = 'Your application has been <b>successfully submited</b>. Our team member will contact you shortly to discuss further details.';
									break;
								case 'Sort Listed':
									statusMessage = '<b>Congratulations!</b> Your application have been <b>shortlisted</b>. Our team member will contact you shortly to discuss further details.';
									break;
								case 'Interview':
									statusMessage = 'You have been selected for an <b>interview</b>. Our team member will contact you shortly to discuss further details.';
									break;
								case 'Hired':
									statusMessage = '<b>Congratulations!</b> You have been <b>selected</b> for the position. Our team member will contact you shortly to discuss further details.';
									break;
								case 'Rejected':
									statusMessage = 'We regret to inform you that your application was <b>not selected</b>.';
									break;
								default:
									statusMessage = 'Your application status has been updated.';
							}

							// CALL EMAIL API
							$.ajax({
								type: 'POST',
								url: '../../API/Admin/sendIndividualStatusEmail.php',
								data: {
									Individuals_Id: appId,
									Status: status,
									Message: statusMessage,
									Job_Title: selectedApplicationData.Job_Title,
									Applicant_Name: selectedApplicationData.Applicant_Name,
									Applicant_Address: selectedApplicationData.Applicant_Address,
									Applicant_Contact: selectedApplicationData.Applicant_Contact,
									Applicant_Email: selectedApplicationData.Applicant_Email
								},
								success: function(emailRes) {
									if (typeof emailRes === 'string') emailRes = JSON.parse(emailRes);
									console.log('Email Response:', emailRes);
								},
								error: function(err) {
									console.error('Email Error:', err);
								}
							});
						}
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
				window.location.href = 'view_individuals.php';
			});

			// CURRENCY INPUT VALIDATION
			$(document).on('input', '.currency-input', function() {
				let enteredValue = parseFloat($(this).val());
				if (isNaN(enteredValue) || enteredValue < 0) {
					$(this).val('');
				}
			});

		});

		let selectedApplicationData = {};

		$(document).on("click", ".view-btn", function() {
			let applicationId = $(this).data("id");

			$.ajax({
				type: "POST",
				url: "../../API/Admin/viewIndividual.php",
				data: {
					Individuals_Id: applicationId
				},
				success: function(response) {

					let data = (typeof response === "string") ? JSON.parse(response) : response;

					if (data.success === "true") {

						selectedApplicationData = data;

						let statusBadge = '';
						if (data.Status === 'Pending') statusBadge = '<span class="badge badge-warning">Pending</span>';
						else if (data.Status === 'Hired') statusBadge = '<span class="badge badge-primary">Hired</span>';
						else if (data.Status === 'Rejected') statusBadge = '<span class="badge badge-danger">Rejected</span>';
						else if (data.Status === 'Interview') statusBadge = '<span class="badge badge-info">Interview</span>';
						else statusBadge = `<span class="badge badge-secondary">${data.Status}</span>`;

						let actionButtons = '';

						if (data.Status === 'Pending') {
							actionButtons = `
								<button class="btn btn-secondary update-status" data-status="Sort Listed" data-id="${data.Individuals_Id}">Sort List</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Individuals_Id}">Reject</button>
							`;
						} else if (data.Status === 'Sort Listed') {
							actionButtons = `
								<button class="btn btn-warning update-status" data-status="Pending" data-id="${data.Individuals_Id}">Pending</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Individuals_Id}">Reject</button>
								<button class="btn btn-info update-status ml-2" data-status="Interview" data-id="${data.Individuals_Id}">Interview</button>
							`;
						} else if (data.Status === 'Interview') {
							actionButtons = `
								<button class="btn btn-warning update-status" data-status="Pending" data-id="${data.Individuals_Id}">Pending</button>
								<button class="btn btn-primary update-status ml-2" data-status="Hired" data-id="${data.Individuals_Id}">Hired</button>
								<button class="btn btn-danger update-status ml-2" data-status="Rejected" data-id="${data.Individuals_Id}">Reject</button>	
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
												<td>${data.Individuals_Id}</td>
											</tr>
											<tr>
												<td><b>Job Title</b></td>
												<td>${data.Job_Title}</td>
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

			$('#Update_Application_Status input[name="Individuals_Id"]').val(Id);
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

</html>