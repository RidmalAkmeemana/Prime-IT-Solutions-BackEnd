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

// Check if user has access to addNewAddon.php
$has_access_to_add_addon = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 194") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_add_addon = true;
}

// Check if user has access to updateAddon.php
$has_access_to_edit_addon = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 196") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_edit_addon = true;
}

// Check if user has access to deleteAddon.php
$has_access_to_delete_addon = false;
$permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 197") or die(mysqli_error());
if (mysqli_num_rows($permission_query) > 0) {
	$has_access_to_delete_addon = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title><?php echo ($companyName); ?> - Packages</title>

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
							<h3 class="page-title">Addons</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Addons</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							<?php if ($has_access_to_add_addon): ?>
								<a href="#Add_Addon" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New Addon</a>
							<?php else: ?>
								<a style="display:none;" href="#" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New Addon</a>
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
												<th>Addon Name</th>
												<th>Addon Description</th>
												<th>Addon Price</th>
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
		<div class="modal fade" id="Add_Addon" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Addon</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/addNewAddon.php" id="addAddonForm" enctype="multipart/form-data">
							<div class="row form-row">

								<div class="col-12">
									<div class="form-group">
										<label>Addon Name</label><label class="text-danger">*</label>
										<input type="text" name="Addon_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Package Description</label><label class="text-danger">*</label>
										<textarea id="add-text" name="Addon_description" class="form-control" rows="8" placeholder="Enter Description . . ."></textarea>
										<p id="count-result">0/250</p>
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Addon Price</label><label class="text-danger">*</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">$</span>
											</div>
											<input type="number" name="Addon_Price" class="form-control text-right currency-input" min="1" step="any" required>
										</div>
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
		<div class="modal fade" id="Update_Addon" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Addon Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="POST" action="../../API/Admin/updateAddon.php" id="updateAddonForm" enctype="multipart/form-data">
							<div class="row form-row">

								<div class="col-12">
									<div class="form-group">
										<label>Addon Name</label><label class="text-danger">*</label>
										<input style="display:none;" type="text" name="Id" class="form-control" required="" readonly="true">
										<input type="text" name="Addon_Name" class="form-control" required="">
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Addon_description</label><label class="text-danger">*</label>
										<textarea id="edit-text" name="Addon_description" class="form-control" rows="8" placeholder="Enter Description . . ."></textarea>
										<p id="count-result">0/250</p>
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>Addon Price</label><label class="text-danger">*</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">$</span>
											</div>
											<input type="number" name="Addon_Price" class="form-control text-right currency-input" min="1" step="any" required="">
										</div>
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
		<div class="modal fade" id="Delete_Addon" aria-hidden="true" role="dialog">
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
							<h4 class="modal-title">Delete <span id="deleteAddonName"></span></h4>
							<p class="mb-4">Are you sure want to delete ?</p>

							<form method="POST" action="../../API/Admin/deleteAddon.php" id="deleteAddonForm" enctype="multipart/form-data">
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
			$('#Delete_Addon').modal('hide');

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
				url: '../../API/Admin/getAllAddonData.php',
				dataType: 'json',
				success: function(data) {
					if (data.length > 0) {
						$('.datatable').DataTable().destroy();

						var table = $('.datatable').DataTable({
							searching: true,
							columnDefs: [
								{
									targets: 3,
									className: 'text-right'
								},
								{
									targets: 4,
									className: 'text-center'
								}
							]
						});

						table.clear();

						$.each(data, function(index, row) {
							const formattedAddonPrice = '$' + row.Addon_Price;
							const canEdit = <?php echo $has_access_to_edit_addon ? 'true' : 'false'; ?>;
							const canDelete = <?php echo $has_access_to_delete_addon ? 'true' : 'false'; ?>;

							let actionButtons = `<div class="actions">`;

							if (canEdit) {
								actionButtons += `
                                <a href="javascript:void(0);"
                                class="btn btn-sm bg-primary-light ms-1 edit-addon-btn"
                                data-id="${row.Id}"
                                data-name="${row.Addon_Name}"
                                data-description="${encodeURIComponent(row.Addon_description)}"
                                data-price="${row.Addon_Price}">
                                    <i class="fe fe-pencil"></i> Edit
                                </a>`;
							}

							if (canDelete) {
								actionButtons += `
                                <a href="javascript:void(0);"
                                class="btn btn-sm bg-danger-light ms-1 delete-addon-btn"
                                data-id="${row.Id}"
                                data-name="${row.Addon_Name}">
                                    <i class="fe fe-trash"></i> Delete
                                </a>`;
							}

							actionButtons += `</div>`;

							table.row.add([
								row.Id,
								row.Addon_Name,
								row.Addon_description,
								formattedAddonPrice,
								actionButtons
							]);
						});

						// After table initialization, hide the column if all actionButtons are empty
						if (!<?php echo ($has_access_to_edit_addon || $has_access_to_delete_addon) ? 'true' : 'false'; ?>) {
							$('.datatable').DataTable().column(4).visible(false); // Hide Actions column
						}

						table.draw();
					}
				},
				error: function(xhr, status, error) {
					console.error('Error fetching addons:', status, error);
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

			initTinyMCE('#add-text', '#Add_Addon #count-result');
			initTinyMCE('#edit-text', '#Update_Addon #count-result');

			// ADD ADDON
			$('#addAddonForm').submit(function(e) {
				e.preventDefault();
				let descriptionText = tinymce.get('add-text').getContent({
					format: 'text'
				}).trim();

				if (!descriptionText.length) {
					$('#Add_Addon').modal('hide');
					$('#EmptyAddon').modal('show');
					tinymce.get('add-text').focus();
					return false;
				}

				tinymce.triggerSave();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/addNewAddon.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showSaveAlerts(response);
					},
					error: function() {
						$('#Add_Addon').modal('hide');
						$('#SaveFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#SaveSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_addons.php';
			});

			// EDIT ADDON
			$(document).on('click', '.edit-addon-btn', function() {
				const Id = $(this).data('id');
				const addonName = $(this).data('name');
				const addonDesc = decodeURIComponent($(this).data('description') || '');
				const addonPrice = $(this).data('price');

				$('#Update_Addon input[name="Id"]').val(Id);
				$('#Update_Addon input[name="Addon_Name"]').val(addonName);
				$('#Update_Addon input[name="Addon_Price"]').val(addonPrice);

				if (tinymce.get('edit-text')) {
					tinymce.get('edit-text').setContent(addonDesc);
				}

				const textLength = addonDesc.replace(/<[^>]*>/g, '').length;
				$('#Update_Addon #count-result').text(`${textLength} / 250`);
				$('#Update_Addon').modal('show');
			});

			$('#updateAddonForm').submit(function(e) {
				e.preventDefault();
				let descriptionText = tinymce.get('edit-text').getContent({
					format: 'text'
				}).trim();

				if (!descriptionText.length) {
					$('#Update_Addon').modal('hide');
					$('#EmptyAddon').modal('show');
					tinymce.get('edit-text').focus();
					return false;
				}

				tinymce.triggerSave();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/updateAddon.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showUpdateAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Update_Addon').modal('hide');
						$('#UpdateFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#UpdateSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_addons.php';
			});

			// DELETE ADDON
			$(document).on('click', '.delete-addon-btn', function() {
				const Id = $(this).data('id');
				const addonName = $(this).data('name');

				$('#Delete_Addon input[name="Id"]').val(Id);
				$('#deleteAddonName').text(addonName);
				$('#Delete_Addon').modal('show');
			});

			$('#deleteAddonForm').submit(function(e) {
				e.preventDefault();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/deleteAddon.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showDeleteAlerts(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.error('Error:', status, error);
						$('#Delete_Addon').modal('hide');
						$('#DeleteFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#DeleteSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_addons.php';
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