<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
?>

<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="index.php" class="navbar-brand logo" style="margin-right: 150px;">
                <img src="assets/img/logo.png" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="index.php" class="menu-logo">
                    <img src="assets/img/logo-small.png" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="main-nav" style="margin-top: 5px;">
                <li class="<?php echo ($currentPage == 'index.php' || $currentPage == 'packageGrid.php' || $currentPage == 'viewPackage.php') ? 'active' : ''; ?>"> 
                    <a href="index.php"><span>Home</span></a>
                </li>
                <li class="<?php echo ($currentPage == 'viewReviews.php') ? 'active' : ''; ?>"> 
                    <a href="viewReviews.php"><span>Reviews</span></a>
                </li>
                <li class="<?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"> 
                    <a href="contact.php"><span>Contact Us</span></a>
                </li>
            </ul>
        </div>
        <ul class="nav header-navbar-rht">
            <li class="nav-item contact-item">
                <div class="header-contact-img">
                    <i class="far fa-hospital"></i>
                </div>
                <div class="header-contact-detail">
                    <p class="contact-header">Contact</p>
                    <p class="contact-info-header" id="headerCompanyTel">
                        <!-- phone will be injected here -->
                    </p>
                </div>
            </li>
        </ul>
    </nav>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    $.ajax({
        url: '../../API/Public/getCompanyDetails.php',
        type: 'GET',
        dataType: 'json',
        success: function (res) {

            if (!res || !res.Company_Name) return;

            // Pick first available phone
            let phone =
                res.Company_Tel1 ||
                res.Company_Tel2 ||
                res.Company_Tel3 ||
                '';

            if (phone) {
                $('#headerCompanyTel').text(phone);
            }

        },
        error: function () {
            console.error('Failed to load company details');
        }
    });

});
</script>