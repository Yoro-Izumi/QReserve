<!DOCTYPE html>
<html lang="en">
<body>

<style>

</style>


<header>
    <nav class="navbar p-0">
        <img src="src/images/Bevitore-logo.png" id="customer-landing-logo" />
        <input type="checkbox" id="menu-toggler">
        <label for="menu-toggler" id="hamburger-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                <path d="M0 0h24v24H0z" fill="none" />
                <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
            </svg>
        </label>
        <ul class="all-links">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'customer_dashboard.php') !== false) echo 'class="active"'; ?>>
                <a href="customer_dashboard.php">Home</a>
            </li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'booking_form.php') !== false) echo 'class="active"'; ?>>
                <a href="booking_form.php">Reservations</a>
            </li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'customer_account.php') !== false) echo 'class="active"'; ?>>
                <a href="customer_account.php">Account</a>
            </li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'customer_logout.php') !== false) echo 'class="active"'; ?>>
                <a href="customer_logout.php">Log Out</a>
            </li>
        </ul>
    </nav>
</header>

</body>
</html>