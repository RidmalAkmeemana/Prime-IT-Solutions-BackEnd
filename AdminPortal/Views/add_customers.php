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

    // Check if user has access to addNewCustomer.php
    $has_access_to_add_customer = false;
    $permission_query = mysqli_query($conn, "SELECT * FROM `tbl_backend_permissions` WHERE `Role` = '$user_status' AND `Backend_Id` = 101") or die(mysqli_error());
    if (mysqli_num_rows($permission_query) > 0) {
        $has_access_to_add_customer = true;
    }
?>


<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title><?php echo($companyName); ?> - Customers</title>
		
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
								<h3 class="page-title">Customers</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Customers</li>
								</ul>
							</div>
							<div class="col-sm-5 col">
								<?php if ($has_access_to_add_customer): ?>
                                	<a href="#Add_Customer" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New Customer</a>
                            	<?php else: ?>
                                	<a style="display:none;" href="#" data-toggle="modal" class="btn btn-primary float-right mt-2"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New Customer</a>
                            	<?php endif; ?>
							</div>
							<div class="col-sm-5 col">
								
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
													<th>Customer ID</th>
													<th>Customer Name</th>
                                                    <th>Customer Contact</th>
													<th>Customer Email</th>
                                                    <th>No. of Orders</th>
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
			<div class="modal fade" id="Add_Customer" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Customer</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="../../API/Admin/addNewCustomer.php" id="addCustomerForm" enctype="multipart/form-data">
								<div class="row form-row">

									<div class="col-12 col-sm-6">
										<div class="form-group">
											<label>Customer Name</label><label class="text-danger">*</label>
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
											<input type="email" name="Customer_Email" class="form-control" required="">
										</div>
									</div>

									<div class="col-12">
										<div class="form-group">
											<label>Customer Address</label><label class="text-danger">*</label>
											<textarea id="add-text" name="Customer_Address" class="form-control" rows="8" placeholder="Enter Customer Address . . ."></textarea>
											<p id="count-result">0/1000</p>
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
		<script  src="assets/js/script.js"></script>

		<!-- Select2 JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
		<script src="https://cdn.tiny.cloud/1/9lf9h735jucnqfgf4ugu8egij1icgzsrgbcmsk5tg44cjba8/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

		<script>
			// GLOBAL ALERT FUNCTIONS
			function showSaveAlerts(response) {
				$('#Add_Customer').modal('hide');

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
				url: '../../API/Admin/getAllCustomerData.php',
				dataType: 'json',
				success: function (data) {
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
								},
								{
									targets: 5,
									className: 'text-center'
								}
							]
						});

						// Clear existing rows
						table.clear();

						$.each(data, function (index, row) {

							const customerEmail = row.Customer_Email ? row.Customer_Email : 'N/A';

							table.row.add([
								row.Customer_Id,
								row.Customer_Name,
								row.Customer_Contact,
								customerEmail,
								row.order_count,
								'<div class="actions"><a class="btn btn-sm bg-success-light" href="view_customer.php?Customer_Id=' + row.Customer_Id + '"><i class="fe fe-eye"></i> View </a></div>'
							]);
						});

						// Draw the table
						table.draw();

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

			initTinyMCE('#add-text', '#Add_Customer #count-result');

			// ADD ADDON
			$('#addCustomerForm').submit(function(e) {
				e.preventDefault();
				let descriptionText = tinymce.get('add-text').getContent({
					format: 'text'
				}).trim();

				if (!descriptionText.length) {
					$('#Add_Customer').modal('hide');
					$('#EmptyAddress').modal('show');
					tinymce.get('add-text').focus();
					return false;
				}

				tinymce.triggerSave();
				$('#pageLoader').show();

				$.ajax({
					type: 'POST',
					url: '../../API/Admin/addNewCustomer.php',
					data: $(this).serialize(),
					success: function(response) {
						if (typeof response === 'string') response = JSON.parse(response);
						showSaveAlerts(response);
					},
					error: function() {
						$('#Add_Customer').modal('hide');
						$('#SaveFailedModel').modal('show');
					},
					complete: function() {
						$('#pageLoader').hide();
					}
				});
			});

			$('#SaveSuccessModel #OkBtn').click(function() {
				window.location.href = 'add_customers.php';
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