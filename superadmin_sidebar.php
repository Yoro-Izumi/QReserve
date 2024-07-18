<?php
include "src/get_data_from_database/get_super_admin_accounts.php";
$superAdminSessionID = $_SESSION['userSuperAdmin'];
$superAdminUsername = " ";
  foreach($arraySuperAdminAccount as $superAdmin){
    if($superAdmin['superAdminID'] === $superAdminSessionID){
      $superAdminUsername = $superAdmin['superAdminUsername'];
    } 
  }
?>
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
      <?php 
        $currentPage = basename($_SERVER['PHP_SELF']);
        
        // Define sections and their respective pages
        $sections = [
          'dashboard' => ['dashboard.php'],
          'reservations' => ['reservations_viewing.php'],
          'services' => ['service_management.php', 'add_new_service.php', 'edit_service.php'],
          'profile' => ['admin-profiles.php', 'add_new_admin.php', 'edit_admin_account.php', 'member-profiles.php', 'add_new_member.php', 'edit_member_account.php'],
          'reports' => ['reports.php']
        ];
        
        // Determine the active section
        $activeSection = '';
        foreach ($sections as $section => $pages) {
          if (in_array($currentPage, $pages)) {
            $activeSection = $section;
            break;
          }
        }
      ?>
      <li>
        <a href="dashboard.php" class="<?= ($activeSection == 'dashboard') ? 'active' : '' ?>">
          <i class="bx bx-home"></i>
          <span class="links_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="reservations_viewing.php" class="<?= ($activeSection == 'reservations') ? 'active' : '' ?>">
          <i class="bx bx-book"></i>
          <span class="links_name">Reservations Viewing</span>
        </a>
        <span class="tooltip">Reservations</span>
      </li>
      <li>
        <a href="service_management.php" class="<?= ($activeSection == 'services') ? 'active' : '' ?>">
          <i class="bx bx-aperture"></i>
          <span class="links_name">Service Management</span>
        </a>
        <span class="tooltip">Services</span>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link <?= ($activeSection == 'profile') ? 'active' : '' ?>" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bx bx-user"></i>
          <span class="links_name dropdown-toggle">Profile Management</span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item <?= ($currentPage == 'admin-profiles.php') ? 'active' : '' ?>" href="admin-profiles.php">Admin Accounts</a></li>
          <li><a class="dropdown-item <?= ($currentPage == 'member-profiles.php') ? 'active' : '' ?>" href="member-profiles.php">Member Accounts</a></li>
        </ul>
      </li>
      <li>
        <a href="reports.php" class="<?= ($activeSection == 'reports') ? 'active' : '' ?>">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Reports</span>
        </a>
        <span class="tooltip">Reports</span>
      </li>
      <li class="profile">
        <div class="profile-details">
          <div class="name_job">
            <div class="name"><?php echo $superAdminUsername;?></div>
            <div class="job">Super Admin</div>
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
