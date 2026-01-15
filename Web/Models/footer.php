<footer class="footer">

    <!-- Footer Top -->
    <div class="footer-top">
        <div class="container-fluid">
            <div class="row">

                <!-- ABOUT -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-about">
                        <div class="footer-logo">
                            <img src="assets/img/logo.png" alt="Logo">
                        </div>
                        <div class="footer-about-content">
                            <p id="footerCompanyDesc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- MENU -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Packages</h2>
                        <ul id="footerPackageList">
                            <!-- Packages will be loaded here dynamically -->
                        </ul>
                    </div>
                </div>

                <!-- CONTACT -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact Us</h2>
                        <div class="footer-contact-info">

                            <div class="footer-address">
                                <span><i class="fas fa-map-marker-alt"></i></span>
                                <p id="footerCompanyAddress"></p>
                            </div>

                            <p id="footerCompanyTel"></p>

                            <p class="mb-0">
                                <i class="fas fa-envelope"></i>
                                <span id="footerCompanyEmail"></span>
                            </p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container-fluid">
            <div class="copyright">
                <div class="row">

                    <div class="col-md-6">
                        <div class="copyright-text">
                            <p class="mb-0" id="footerCompanyName"></p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="copyright-menu">
                            <ul class="policy-menu">
                                <li>
                                    <a href="#">
                                        Copyright &copy; <?php echo date("Y"); ?>
                                        <span id="footerCompanyNameCopy"></span> |
                                        Powered by Orbis Solutions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    $.ajax({
        url: '../../API/Public/getCompanyDetails.php',
        type: 'GET',
        dataType: 'json',
        success: function (res) {

            if (!res || !res.Company_Name) return;

            $('#footerCompanyName').text(res.Company_Name);
            $('#footerCompanyNameCopy').text(res.Company_Name);

            $('#footerCompanyAddress').text(res.Company_Address);
            $('#footerCompanyEmail').text(res.Company_Email);

            // Build phone list safely
            let phones = [];
            if (res.Company_Tel1) phones.push(res.Company_Tel1);
            if (res.Company_Tel2) phones.push(res.Company_Tel2);
            if (res.Company_Tel3) phones.push(res.Company_Tel3);

            $('#footerCompanyTel').html(
                `<i class="fas fa-phone-alt"></i> ${phones.join(' | ')}`
            );

        },
        error: function () {
            console.error('Failed to load company details');
        }
    });

    /* ==========================
       LOAD PACKAGES
    ========================== */
    $.ajax({
        url: '../../API/Public/getAllPackageData.php',
        type: 'GET',
        dataType: 'json',
        success: function (packages) {

            const $list = $('#footerPackageList');
            $list.empty();

            if (!Array.isArray(packages) || packages.length === 0) {
                $list.append('<li>No packages available</li>');
                return;
            }

            packages.forEach(pkg => {
                $list.append(`
                    <li>
                        <a href="viewPackage.php?Package_Id=${pkg.Package_Id}">
                            <i class="fas fa-angle-double-right"></i>
                            ${pkg.Package_Name}
                        </a>
                    </li>
                `);
            });
        },
        error: function () {
            console.error('Failed to load packages');
        }
    });

});
</script>