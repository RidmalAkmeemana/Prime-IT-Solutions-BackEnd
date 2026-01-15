<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Popular Section -->
        <section class="section section-doctor">
            <div class="container-fluid">
                <div class="row" id="packageContainer"></div>
            </div>
        </section>
        <!-- /Popular Section -->


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

    <script>
        $(document).ready(function() {

            $.ajax({
                url: '../../API/Public/getAllPackageData.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    console.log('RAW JSON:', response); //JSON stays JSON

                    if (!Array.isArray(response)) {
                        console.error('Invalid response format');
                        return;
                    }

                    let html = '';

                    $.each(response, function(index, pkg) {

                        let descriptionHTML = $('<div>').html(pkg.Package_Description).html();

                        html += `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="profile-widget h-100">
                        <div class="pro-content">

                            <h4 style="display:none;">${pkg.Package_Id}</h4>
							<h4 class="mb-2">${pkg.Package_Name}</h4>
							<h2 class="mb-2">$ ${parseFloat(pkg.Price).toFixed(2)}</h2>
							<hr></hr>

                            <div class="package-desc mb-3">
								<p class="text-primary">Package Details</p>
                                ${descriptionHTML}
                            </div>

                            <div class="row row-sm mt-3">
                                <div class="col-12">
                                    <a href="viewPackage.php?Package_Id=${pkg.Package_Id}"
                                       class="btn btn-primary btn-block">
                                        Book Now
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>`;
                    });

                    $('#packageContainer').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });

        });
    </script>

</body>

<!-- doccure/index.html  30 Nov 2019 04:12:03 GMT -->

</html>