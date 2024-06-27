<!DOCTYPE html>
<html lang="en">
<body>
<div class="sidebar">
    <div class="logo-details">
      <img src="src/images/Bevitore-logo.png" class="img-fluid icon" id="sidebar-logo" />
      <div class="logo_name qreserve ms-2 mb-0">QReserve</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <!-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> -->
      <li>
        <a href="dashboard.php">
          <i class="bx bx-home"></i>
          <span class="links_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="reservations_viewing.php">
          <i class="bx bx-book"></i>
          <span class="links_name">Reservations Viewing</span>
        </a>
        <span class="tooltip">Reservations</span>
      </li>
      <li>
        <a href="service_management.php">
          <i class="bx bx-aperture"></i>
          <span class="links_name">Service Management</span>
        </a>
        <span class="tooltip">Services</span>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bx bx-user"></i>
          <span class="links_name dropdown-toggle">Profile Management </span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="admin-profiles.php">Admin Accounts</a></li>
          <li><a class="dropdown-item" href="member-profiles.php">Member Accounts</a></li>
        </ul>
      </li>
      <li>
        <a href="reports.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Reports</span>
        </a>
        <span class="tooltip">Reports</span>
      </li>

      <li class="profile">
        <div class="profile-details">
          <div class="name_job">
            <div class="name">Admin Name</div>
            <div class="job">Web designer</div>
          </div>
        </div>
        <a href="logout.php">
          <i class="bx bx-log-out" id="log_out"></i>
        </a>   
      </li>
    </ul>
  </div>
</body>
</html>