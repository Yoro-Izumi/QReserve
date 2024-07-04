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
    <li>
      <a href="admin_dashboard.php">
        <i class="bx bx-home"></i>
        <span class="links_name">Home</span>
      </a>
      <span class="tooltip">Home</span>
    </li>
    <li>
      <a href="admin_reservations_viewing.php">
        <i class="bx bx-book"></i>
        <span class="links_name">Reservations Viewing</span>
      </a>
      <span class="tooltip">Reservations</span>
    </li>
    <li>
      <a href="admin_walk_in_form.php">
        <i class="bx bx-file"></i>
        <span class="links_name">Walk-In Form</span>
      </a>
      <span class="tooltip">Walk-In</span>
    </li>
    <li class="profile">
      <div class="profile-details">
        <div class="name_job">
          <div class="name">Admin</div>
          <div class="job">Front-Desk</div>
        </div>
      </div>
      <!-- Change the logout link to trigger the modal -->
      <a href="#" id="logoutLink">
        <i class="bx bx-log-out" id="log_out"></i>
      </a>   
    </li>
  </ul>
</div>

<!-- First Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fw-bold text-center" id="logoutModalLabel">
          <img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
      </div>
      <div class="modal-body">
        <p class="text-center mb-0 pb-0">Has your shift ended?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary create-button" id="proceedLogoutButton">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Second Confirmation Modal -->
<div class="modal fade" id="confirmLogoutModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="confirmLogoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="wait">
      <div class="modal-header">
        <h2 class="modal-title fw-bold text-center" id="confirmLogoutModalLabel">
          <img src="src/images/icons/thank-you.gif" alt="Wait Icon" class="modal-icons">Great!</h2>
      </div>
      <div class="modal-body">
        <p class="text-center mb-0 pb-0">Thank you</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button" id="finalLogoutButton">Logout</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const logoutLink = document.getElementById('logoutLink');
    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    const confirmLogoutModal = new bootstrap.Modal(document.getElementById('confirmLogoutModal'));
    const proceedLogoutButton = document.getElementById('proceedLogoutButton');
    const finalLogoutButton = document.getElementById('finalLogoutButton');

    logoutLink.addEventListener('click', (event) => {
      event.preventDefault();
      logoutModal.show();
    });

    proceedLogoutButton.addEventListener('click', () => {
      logoutModal.hide();
      confirmLogoutModal.show();
    });

    finalLogoutButton.addEventListener('click', () => {
      window.location.href = 'logout.php';
    });
  });
</script>
</body>
</html>