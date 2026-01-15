<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['status']);
unset($_SESSION['token']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo ($companyName); ?> - Log Out</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dark_mode_style.css">

    <style>
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

    <script>
        let startTime = performance.now();

        window.addEventListener("load", function() {
            let endTime = performance.now();
            let loadTime = endTime - startTime;
            let delay = Math.max(loadTime); // Ensure a minimum loadTime delay for UX

            setTimeout(function() {
                window.location.href = "index.php"; // Redirect to login/home page
            }, delay);
        });
    </script>
</body>

</html>