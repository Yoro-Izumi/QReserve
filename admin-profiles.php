<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Profiles</title>
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Online Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <!-- Datatables -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- External CSS -->
    <link rel="stylesheet" href="./css/sidebar.css" />
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-details">
        <img
          src="./images/Bevitore-logo.png"
          class="img-fluid icon"
          id="sidebar-logo"
        />
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
          <a href="dashboard.html">
            <i class="bx bx-home"></i>
            <span class="links_name">Home</span>
          </a>
          <span class="tooltip">Home</span>
        </li>
        <li>
          <a href="reservations_viewing.html">
            <i class="bx bx-book"></i>
            <span class="links_name">Reservations Viewing</span>
          </a>
          <span class="tooltip">Reservations</span>
        </li>
        <li>
          <a href="service management.html">
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
            <li><a class="dropdown-item" href="admin-profiles.html">Admin Accounts</a></li>
            <li><a class="dropdown-item" href="member-profiles.html">Member Accounts</a></li>
          </ul>
        </li>
        <li>
          <a href="reports.html">
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Reports</span>
          </a>
          <span class="tooltip">Reports</span>
        </li>

        <li class="profile">
          <div class="profile-details">
            <div class="name_job">
              <div class="name">Prem Shahi</div>
              <div class="job">Web designer</div>
            </div>
          </div>
          <a href="index.html">
            <i class="bx bx-log-out" id="log_out"></i>
          </a>
        </li>        
      </ul>
    </div>

    <section class="home-section">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="krona-one-regular mt-">Admin Accounts</h4>
        <a href="add_new_admin.html" type="button" class="btn btn-primary fw-bold mb-0" id="add-new-profile">Add New Admin</a>
      </div>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab" id="profile-management">
        <table id="example" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <tr>
                <th>Actions</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Username</th>
                <th>Contact Number</th>
                <th>Email Address</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Tiger Nixon</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
              <td>61</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>63</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>63</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>63</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
              <td>Tokyo</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>63</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>63</td>
              <td>System Architect</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
            </tr>
            <tr>
              <td><input type="checkbox"></td> 
              <td>Garrett Winters</td>
              <td>Accountant</td>
              <td>Tokyo</td>
              <td>System Architect</td>
              <td>Edinburgh</td>
            </tr>
          </tbody>
        </table>
        <div class="mt-3">
          <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button>
          <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button>
        </div>        
      </div>  
    </section>

    <script>
      $(document).ready(function () {
        $("#example").DataTable({
          paging: true,
          lengthChange: true,
          searching: true,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
        });
      });
  
      // JavaScript functions for handling bulk actions
      function deleteSelected() {
        // Implement delete logic here
        console.log("Delete selected rows");
      }
  
      function editSelected() {
        // Implement edit logic here
        console.log("Edit selected rows");
      }
    </script>
  
    <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");
  
      closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });
  
      searchBtn.addEventListener("click", () => {
        // Sidebar open when you click on the search icon
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });
  
      // following are the code to change sidebar button(optional)
      function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the icons class
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the icons class
        }
      }
    </script>
  </body>
</html>
