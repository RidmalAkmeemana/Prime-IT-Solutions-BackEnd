<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name

    $query = mysqli_query($conn, "SELECT * FROM `tbl_user` WHERE `username` = '$_SESSION[user]'") or die(mysqli_error());
    $fetch = mysqli_fetch_array($query);
    $role = $fetch['Status'];

    function hasPermission($role, $screen, $conn) {
        $screenQuery = mysqli_query($conn, "SELECT Screen_Id FROM `tbl_screens` WHERE `Screen_Name` = '$screen'") or die(mysqli_error());
        if (mysqli_num_rows($screenQuery) > 0) {
            $screenFetch = mysqli_fetch_array($screenQuery);
            $screenId = $screenFetch['Screen_Id'];

            $permissionQuery = mysqli_query($conn, "
                SELECT * 
                FROM `tbl_screen_permissions` 
                WHERE `Role` = '$role' AND `Screen_Id` = '$screenId'
            ") or die(mysqli_error());

            return mysqli_num_rows($permissionQuery) > 0;
        }
        return false;
    }
?>

<style>
    .sidebar {
    position: fixed;
    overflow: hidden;
}

.sidebar-inner {
    height: 100%;
    overflow-y: auto;      /* enable scrolling */
    overflow-x: hidden;
    padding-bottom: 50px;  /* prevents last item from being cut off */
}

/* Smooth scroll */
.sidebar-inner::-webkit-scrollbar {
    width: 6px;
}
.sidebar-inner::-webkit-scrollbar-thumb {
    background: #aaa;
    border-radius: 10px;
}

</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="<?php echo ($currentPage == 'home.php') ? 'active' : ''; ?>"> 
                    <a href="home.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
                </li>

                <p class="menu-title" style="color:#949494;"><span>Main Pages</span></p>

                <?php if (hasPermission($role, 'add_packages.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'add_packages.php' || $currentPage == 'view_packages.php') ? 'active' : ''; ?>"> 
                    <a href="add_packages.php"><i class="fa fa-dropbox" aria-hidden="true"></i> <span>Packages</span></a>
                </li>
                <?php } ?>

                <?php if (hasPermission($role, 'add_addons.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'add_addons.php' || $currentPage == 'view_addons.php') ? 'active' : ''; ?>"> 
                    <a href="add_addons.php"><i class="fa fa-gift" aria-hidden="true"></i> <span>Addons</span></a>
                </li>
                <?php } ?>

                <?php if (hasPermission($role, 'add_users.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'add_users.php' || $currentPage == 'view_user.php') ? 'active' : ''; ?>"> 
                    <a href="add_users.php"><i class="fa fa-user-secret"></i> <span>Users</span></a>
                </li>
                <?php } ?>

                <?php if (hasPermission($role, 'add_roles.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'add_roles.php' || $currentPage == 'view_role.php') ? 'active' : ''; ?>"> 
                    <a href="add_roles.php"><i class="fa fa-id-card-o"></i> <span>User Roles</span></a>
                </li>
                <?php } ?>

                <?php if (hasPermission($role, 'add_customers.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'add_customers.php' || $currentPage == 'view_customer.php') ? 'active' : ''; ?>"> 
                    <a href="add_customers.php"><i class="fa fa-users"></i> <span>Customers</span></a>
                </li>
                <?php } ?>

                <p class="menu-title" style="color:#949494;"><span>Order Management</span></p>

                <?php if (hasPermission($role, 'orders.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'orders.php' || $currentPage == 'view_order.php') ? 'active' : ''; ?>"> 
                    <a href="orders.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>Orders</span></a>
                </li>
                <?php } ?>

                <?php if (hasPermission($role, 'reviews.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'reviews.php') ? 'active' : ''; ?>"> 
                    <a href="reviews.php"><i class="fa fa-star" aria-hidden="true"></i> <span>Reviews & Feedbacks</span></a>
                </li>
                <?php } ?>

                <p class="menu-title" style="color:#949494;"><span>Configuration</span></p>

                <?php if (hasPermission($role, 'settings.php', $conn)) { ?>
                <li class="<?php echo ($currentPage == 'settings.php') ? 'active' : ''; ?>"> 
                    <a href="settings.php"><i class="fa fa-cogs"></i> <span>System Information</span></a>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const activeItem = document.querySelector('.sidebar-menu li.active');
        if (activeItem) {
            const sidebarInner = document.querySelector('.sidebar-inner');
            const offsetTop = activeItem.offsetTop;
            sidebarInner.scrollTop = offsetTop - 100; // Adjust as needed
        }
    });
</script>
