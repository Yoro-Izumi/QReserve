<!DOCTYPE html>
<html lang="en">
<body>
<div class="sidebar">
    <div class="logo-details">
      <img src="src/images/Bevitore-logo.png" class="img-fluid icon" id="sidebar-logo" />
      <div class="logo_name krona-one-regular ms-2 mb-0">QReserve</div>
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

      <li class="profile">
        <div class="profile-details">
          <div class="name_job">
            <div class="name">Prem Shahi</div>
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