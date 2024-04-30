<?php
session_start();
date_default_timezone_set('Asia/Manila');
if(isset($_SESSION["userSuperAdminID"])){
  include "connect_database.php";
  include "get_data_from_database/get_services.php";
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Services</title>
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Online Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />

  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

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
<?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="krona-one-regular mt-">Service Management</h4>
      <!-- <a href="add_new_service.php" type="button" class="btn btn-primary fw-bold mb-0" id="add-new-profile">Add New Service</a> -->
      <button type="button" class="btn btn-primary fw-bold mb-0" data-bs-toggle="modal" data-bs-target="#add-service-modal" id="add-new-profile">Add New Service</button>
    </div>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab" id="profile-management">
      <table id="example" class="table table-striped" style="width: 100%">
        <thead>
          <tr>
          <tr>
            <th>Actions</th>
            <th>Service Name</th>
            <th>Rates</th>
            <th>Capacity</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($arrayServices as $services){
        ?>
          <tr>
            <td><input type="checkbox" value="<?php echo $services['serviceID'];?>"></td>
            <td><?php echo $services['serviceName'];?></td>
            <td><?php echo $services['normalPrice'];?></td>
            <td> </td>
            <td><?php echo $services['serviceImage'];?></td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      <div class="mt-3">
        <!-- <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button> -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal" id="delete-service">Delete Selected</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-modal" id="edit-service">Edit Selected</button>
        <!-- <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button> -->
      </div>
    </div>
  </section>






<!-- Modals -->

<!-- Add New Service Modal -->
<div class="modal fade" id="add-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered service-modal" id="add-new-service-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACMElEQVR4nO1ZvU4bQRBekUhJlZ8u5DnArZtIcZiRZ4x0NW9BSOUC6mB4gfQOnjFSRJtnCHkBoECgKCkxNCYa20JRDOLu9n724D5ppdPZu/t9O7tzszPO1ahRwxvdbncBhBsovAHCeyh8iMJ/QOnKmj3P3n2d/adhfVzZeD/oLILSFgifoPJ1kgbCx9bXxiicOHyD16C0g0qjpMTnG41sLFJ6VQj5FeFVUDr3Jz5nkTMbOzfiUT96Ml31bInjvEV6Nlem5Jtf1p6jsORPnqdNWGzOTMjbaky8R1Hk9UbEfvN786m3gGK2Dd8lYtuLvB2q0sjrRMAYhu1OKvLv+tFLVDotVYBOvZO57cQCUHg37aR3IbUIpZ1E5Ff60RtQughFACqN2sP229gC7BPvY/bsBbBZYStJYHYcmgBUOooVAE6iSs+Dl48Avv4wbC/FEfApVAGgtB5HwF6oAlCpf68AVPrpQzItMI4A4cM4An6HKgCEf92/hewKGKgAFL58+AKw6lsIq36IoepuFB7Ah6xR6VCiW/VgLuBwetM9mguNbzYiBwE9lxStg9aLUC71lDZvOkmrCI9LEyA2N7HzgZmvxNX/7KqcWoyySvK2DlrPCk3uKg1sTpclZpbYzvVMCI9t22SeXv8Xlqs0z5DDfj9LnQdNCnNrWZaYUKlXWInpliLfZrrYiY6sbylFvv9hQRYOOsug9NE8Fgj/sJvdTZnVnu2d/aa0blFlEGXWGjVc9fEXqO3rql/ZpoIAAAAASUVORK5CYII=">Add New Service</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="needs-validation" id="add-new-profile-form" novalidate action="BABAGUHIN ITU.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-12 mb-3">
            <label for="serviceName" class="form-label">Service Name <span>*</span></label>
            <input type="text" class="form-control" name="serviceName" id="serviceName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">
              Please enter a valid first name.
            </div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="serviceRate" class="form-label">Rate</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="text" class="form-control" name="serviceRate" id="serviceRate" placeholder="Enter rate here" pattern="^\d+(\.\d{1,2})?$" required oninvalid="this.setCustomValidity('Please enter a valid rate')" oninput="this.setCustomValidity('')" />
            </div>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid rate.</div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="text" class="form-label">Capacity <span>*</span></label>
            <input type="email" class="form-control" name="capacity" id="capacity" placeholder="Enter service capacity here" required oninvalid="this.setCustomValidity('Please enter a valid capacity')" oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label for="image" class="form-label">Image <span>*</span></label>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png" required>
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary create-button" data-bs-target="#confirm-add-service-modal" data-bs-toggle="modal">Confirm</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirmation Add Service Modal -->
<div class="modal fade" id="confirm-add-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel">Here's what we received:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        dito nakalagay yung mga inputs from the previous modal.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button" data-bs-target="#success-add-service-modal" data-bs-toggle="modal">Confirm</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Success Add New Service Modal -->
<div class="modal fade" id="success-add-service-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel2"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO2Zz2tTQRDHH/46ePTHyR//hFjsKTcp7MrOOzyUelHRnqUQLb3k1noQW6glLf4HKW8GUvWi4NGW9qIogje1J/vj3Aj1yWxfAw0vyW7evk2EDAykDcn7fGd3ZmcnQTC0oQ0tt0W16KREGBWkpiWpWCB8lQh7ktQf7Qh7AuGLfo/U9K04vFGpVE4E/TZF6opEeCYRtiRBYufqlyA1OxaHl72Dj9Wii5JgWZBq2IMfd0GqIUhVZV1e8AIvSY1LUrt5wTOE7Ig4vFMY+LXlidMC4ZVrcNkqBGGJn+UUXtblWUHqbdHw8sgR3vAz3UXeJzw1RbyLatGZ3AJ8bBvZPi+q+eDj8G6/4GXT1e2e4AHhvEDYHgABuz2VWK7zPkHvvR9vv5UQFq3g+XR0cUiZ+uTHB8nawYtk/vtku1xoyLq8ah59bg88w28m89o7iJg1gucmi/sUH/DltUfJ+sFcE56d/76ftZ0QtrhpNIn+aD8iv5nCs6gOuTDSVcBhS1ws/JP1h5mRL3eAT1dhymQFcCDhSQtY6b4C+uIxgPCkBXzuvgIWrXKn2m2asGVT+MMc2DbJAaP6//zbY2OA3JGn5grsOxHA8KYgzuDJUEC3LcQ12hTIKTyZbiGDJM6q4Rt/55KpjYnC4KVxEhuW0U4iCoEn0zJqcZC1qyxZ/2NRueBJ90NPuwrgoZPNl2athPPIU+pxeN2omRMIP12IcAkvEH4YT/O4dbV9QKsIp5EndjUTFH2hORLhHB5hX6yKS8YC0lWo9vIwTlYXCSuPR38hsLWbtejcIFzqBamdnuemPKvsuwAMo57gmyIQlvoY/ZdBXuN7qEAg/wLU69KH0qnAhfGgVQ9c/UV+1dlwt2XIW/WxbUquIp9lPKsspjqp37kT1nJuusgHTG5w5O9QC1y2A9/GpyO3Hba9k94q+jNqxvqELcLSBnCE5zbcs/PFg2926Q94Df0a4RO/xy0xd5UD8TPr0IYW/P/2D5+LFXPdole1AAAAAElFTkSuQmCC">Success</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      You have successfully added a new service.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary create-button" data-bs-target="#" data-bs-toggle="modal">Go back</button>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" id="delete-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAE1UlEQVR4nO3ZW1MaZxgHcO7TmdzkupHDcmY59aLJN+j0Jk5n+hVipzf9BLV3+QIVwyoeUFA5i4igiCAgYA4am1obTarRNjE1wiS9zPTf2YWV4y6gS9OZ8sxw4wF+/3fefd6HXZGoV73q1f+7Ps0NfdmXt5z05YfRyetm3nJ8c9Pyxcf2i2hIp/iLELnhl/86WP3j6SemkaLZRBW/NlGF79T+PHSuHZCOfRimDmGYOIFx/BVMtjcwUYXSy/aG+Rn9O/pv9I4DaF1PQP8v/R7Me40UzaT91TVBsWbr+fXPrIWvzFThnpkqRM1U8chMFdG1l7Xwt9laPCx9VuEe89nW8+tXCFDY7SqYaivU7qUDmKyFxY8egCqERFetvpzloOVFmbsPcc4KcXYE4uwoxBs2iDNjkGTGIUlPQJKehCRlhzQ1Ben6NKTrDkiTTkgTM5AlZiFbm4NszQVZ3A0i7gER8+5fGV4JMJzhhlshzlHtw5NccA+IuBfEqg9EzA9ZzJ8WMIDFVwu/XwvfaB8uu4C7IFtzN8CJWADylXnIV4JeIQMM88ElzeDr1fAyOjFXC19tCod8eQFENGQRLMDN/PAPDDzbLry8TS4Bl0dDkEcXIY+EB4ULsEENcMJTNLzuwqyHx9uDK6JhKCJLUEQiUCxF7woYwNZfCy+tdjtwggu+TMNDzGrXwaFYWoZqMXZHsADSzNht3laY5GiFDfDyavPAleEVKBdjUAZXbgkWgEjZJB31cAZeQhPV24QLHq6CL65CGYpDPp8UCxaAjNqvtYaXV7sDuLIJXBVKQLWQBBmNCjvYSZLOv2rhvD28OXypGTwOZWjtAq4KrkMZTL0XCV3SxNxBG4dPLTzSDF5ebRa+UIGrgimo59NQBdLCjRFsydZcmZatsCm8vNpVcBUHXD2fgTqwAZU/mxY+wKrH1+rwKcHrOkq4en/zw9X+LDT+HNTevHBjBFtEzG9phPO0wnbgARaeg8afh8a3CY3vAdSeB0OCB5AvBwbb7uEt4RtQB7INcI33IbTeR9B6Hn8veADZcnDgsvCabcIF9zBwaN1b0Lq2hBsj2CKi4f7WPZyFN9nf7cDd28yXfe3sjnBjBFuKSOR2q8On6YVZD/dywXegc/0E3dxTaF27wo0RbBGhFQnf4dM5fBta9xPmloxurgTXzf4M3ewuSNeecGMEW/TRznf4VMPpVqjx1cMfQ+vZ4ofP/AJyZg+kfVvYMYIt5ULifaseXoE/hKbUUSpwVwu481eQjmfvuoJnAgSTB9zwyoV5STj0jn2Q08+FHyPYUs2nMlyHTw3czQ0nWbiThe8ztxr108+hn34B0v5C+DGCLbU/6+M5fPjhMzS8jHY+a4Drp36DwX4Ig/3I28UAOUurHl4Lr9sm/HAYJl9CP3E81L0Avs1BfjjH/q6HTzXCDZPHMNJ3r8dPhB8j2NK6Hw1wHT5ccH1b8N9hHP+DuQVvHHt9t3sBXFv9LXt4NXyaC34Mw+RJPRzGsVOYR1/f6WKAnVuXgx/BYC+tNvMApA5uGjstPRCx/QkTdfZ51wKYHXs3tDNPP3D18BK8jKaf1nQCHz2DkTr7YLa+uyHqZumcu9+Szr3zCryuo0zV7m9e+GgJbhp5CxN1/tZsLX7TVXyvetUr0X+u/gHPoo07Y1s3egAAAABJRU5ErkJggg==">Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Are you sure you want to delete this service?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button" data-bs-target="#success-delete-modal" data-bs-toggle="modal">Confirm</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Success Delete Modal -->
<div class="modal fade" id="success-delete-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel2"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO2Zz2tTQRDHH/46ePTHyR//hFjsKTcp7MrOOzyUelHRnqUQLb3k1noQW6glLf4HKW8GUvWi4NGW9qIogje1J/vj3Aj1yWxfAw0vyW7evk2EDAykDcn7fGd3ZmcnQTC0oQ0tt0W16KREGBWkpiWpWCB8lQh7ktQf7Qh7AuGLfo/U9K04vFGpVE4E/TZF6opEeCYRtiRBYufqlyA1OxaHl72Dj9Wii5JgWZBq2IMfd0GqIUhVZV1e8AIvSY1LUrt5wTOE7Ig4vFMY+LXlidMC4ZVrcNkqBGGJn+UUXtblWUHqbdHw8sgR3vAz3UXeJzw1RbyLatGZ3AJ8bBvZPi+q+eDj8G6/4GXT1e2e4AHhvEDYHgABuz2VWK7zPkHvvR9vv5UQFq3g+XR0cUiZ+uTHB8nawYtk/vtku1xoyLq8ah59bg88w28m89o7iJg1gucmi/sUH/DltUfJ+sFcE56d/76ftZ0QtrhpNIn+aD8iv5nCs6gOuTDSVcBhS1ws/JP1h5mRL3eAT1dhymQFcCDhSQtY6b4C+uIxgPCkBXzuvgIWrXKn2m2asGVT+MMc2DbJAaP6//zbY2OA3JGn5grsOxHA8KYgzuDJUEC3LcQ12hTIKTyZbiGDJM6q4Rt/55KpjYnC4KVxEhuW0U4iCoEn0zJqcZC1qyxZ/2NRueBJ90NPuwrgoZPNl2athPPIU+pxeN2omRMIP12IcAkvEH4YT/O4dbV9QKsIp5EndjUTFH2hORLhHB5hX6yKS8YC0lWo9vIwTlYXCSuPR38hsLWbtejcIFzqBamdnuemPKvsuwAMo57gmyIQlvoY/ZdBXuN7qEAg/wLU69KH0qnAhfGgVQ9c/UV+1dlwt2XIW/WxbUquIp9lPKsspjqp37kT1nJuusgHTG5w5O9QC1y2A9/GpyO3Hba9k94q+jNqxvqELcLSBnCE5zbcs/PFg2926Q94Df0a4RO/xy0xd5UD8TPr0IYW/P/2D5+LFXPdole1AAAAAElFTkSuQmCC">Success</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      You have deleted this service.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary create-button" data-bs-target="#" data-bs-toggle="modal">Go back</button>
      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered service-modal" id="add-new-service-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAACXBIWXMAAAsTAAALEwEAmpwYAAADB0lEQVR4nO3XSU8TARiH8YkmetYDiFE/gPvJg8FEpnZK6UCFpAIRkgoHRRSjskgLFIEa9qlSkC60FC9aREIPQEuRsnVBISJEQ0BiwACCMYChtYu+ZpBiQSXGw3SMfZL//Zd3Zg6DIIG2TsvjbTczGGcsDMYNM4ryekNDdyF0yYKiwTYWa2SIy10eT052jsTFLVuZzGUriob524YoL6UdJgR37KOpV1wOggDv5gUCsDKZn8wYttuvOHFxjbuqQQelEhUsEJJ1ILnR2Ngl8nH7BXezrCYov1z5/lFrH4zNrsCTzmdQQqhhvvIHcjw5+bOZwbhOOU4uvXwol1BNP2y3OEmcd5uRg5GRy9awMJRSXJM8el+hROpuaDGtw3zXaLBBKaEG8p20YdgwiETbKMPpa5hBnWp8srVZ7C6UamBgbO6XyCqNDohssZ38uinHTfSlO+HjA3jxXAMk0vp6ZgPusd4K4uL7bkVK2lG/4WBtm5GNBptLVK74QCnOqECDjSr87URfpssX592grQEKqupB02KCPInqXbZEQfFjVf18uc3r0BV5iiTVbqn02nHa4SbNWa5ONT6llfEO0BbXJmOFBHBkgcv935ezBHC/uVzvn13OoDyzF6EdznwrgNtQ4HJ/m7YMPaiX447xnnQXLXHtctw93pMONMVFuEb0KVvi3vRnruK61BF7ECpT5rF0T+viPSYNF1xzdfTCyQSskNoczLFouw3DzXwwaaJg4VXJBtxEf8YXowqfphxHVitkFnXIEx0rQ2IgN9uTBV2aKHDOKNYulwF6BcfTWIpS94PjTSvi7ZDlYosz3cJVnHcvW5Kgqz4KhtsugkHB8WhLmdT9Q/jGj2cTlYKYFV8cucWBAjCpEjxtsgi333BkbA5uP8Xkglmb9f3xdgvBqEh0ynIwR10+W9dUgR1D/FVSAot/4nQkkCOREmGMXZ6LLclysIpqIbYf8Xcx0ZwpLzCcgzv48Zx7d6+G70ToUCqffeQkA//KPcuZSYhjZyJ0K+k8zrhwzo/vF/IP9w1CYb0wOS+LwAAAAABJRU5ErkJggg==">Edit Service</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="needs-validation" id="add-new-profile-form" novalidate action="BABAGUHIN ITU.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-12 mb-3">
            <label for="serviceName" class="form-label">Service Name <span>*</span></label>
            <input type="text" class="form-control" name="serviceName" id="serviceName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">
              Please enter a valid first name.
            </div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="serviceRate" class="form-label">Rate</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="text" class="form-control" name="serviceRate" id="serviceRate" placeholder="Enter rate here" pattern="^\d+(\.\d{1,2})?$" required oninvalid="this.setCustomValidity('Please enter a valid rate')" oninput="this.setCustomValidity('')" />
            </div>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid rate.</div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="text" class="form-label">Capacity <span>*</span></label>
            <input type="email" class="form-control" name="capacity" id="capacity" placeholder="Enter service capacity here" required oninvalid="this.setCustomValidity('Please enter a valid capacity')" oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label for="image" class="form-label">Image <span>*</span></label>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png" required>
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button" data-bs-target="#confirm-edit-modal" data-bs-toggle="modal">Confirm</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Confirm Edit Modal -->
<div class="modal fade" id="confirm-edit-modal" aria-hidden="true" aria-labelledby="confirm-edit-modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="confirm-edit-modal"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO2Zz2tTQRDHH/46ePTHyR//hFjsKTcp7MrOOzyUelHRnqUQLb3k1noQW6glLf4HKW8GUvWi4NGW9qIogje1J/vj3Aj1yWxfAw0vyW7evk2EDAykDcn7fGd3ZmcnQTC0oQ0tt0W16KREGBWkpiWpWCB8lQh7ktQf7Qh7AuGLfo/U9K04vFGpVE4E/TZF6opEeCYRtiRBYufqlyA1OxaHl72Dj9Wii5JgWZBq2IMfd0GqIUhVZV1e8AIvSY1LUrt5wTOE7Ig4vFMY+LXlidMC4ZVrcNkqBGGJn+UUXtblWUHqbdHw8sgR3vAz3UXeJzw1RbyLatGZ3AJ8bBvZPi+q+eDj8G6/4GXT1e2e4AHhvEDYHgABuz2VWK7zPkHvvR9vv5UQFq3g+XR0cUiZ+uTHB8nawYtk/vtku1xoyLq8ah59bg88w28m89o7iJg1gucmi/sUH/DltUfJ+sFcE56d/76ftZ0QtrhpNIn+aD8iv5nCs6gOuTDSVcBhS1ws/JP1h5mRL3eAT1dhymQFcCDhSQtY6b4C+uIxgPCkBXzuvgIWrXKn2m2asGVT+MMc2DbJAaP6//zbY2OA3JGn5grsOxHA8KYgzuDJUEC3LcQ12hTIKTyZbiGDJM6q4Rt/55KpjYnC4KVxEhuW0U4iCoEn0zJqcZC1qyxZ/2NRueBJ90NPuwrgoZPNl2athPPIU+pxeN2omRMIP12IcAkvEH4YT/O4dbV9QKsIp5EndjUTFH2hORLhHB5hX6yKS8YC0lWo9vIwTlYXCSuPR38hsLWbtejcIFzqBamdnuemPKvsuwAMo57gmyIQlvoY/ZdBXuN7qEAg/wLU69KH0qnAhfGgVQ9c/UV+1dlwt2XIW/WxbUquIp9lPKsspjqp37kT1nJuusgHTG5w5O9QC1y2A9/GpyO3Hba9k94q+jNqxvqELcLSBnCE5zbcs/PFg2926Q94Df0a4RO/xy0xd5UD8TPr0IYW/P/2D5+LFXPdole1AAAAAElFTkSuQmCC">Success</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      You have edited this service.
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary create-button" data-bs-target="#" data-bs-toggle="modal">Go back</button>
      </div>
    </div>
  </div>
</div>

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

<script>
    //For Rate
    document.addEventListener("DOMContentLoaded", function() {
      const serviceRateInput = document.querySelector("#serviceRate");

      // Add event listener for input
      serviceRateInput.addEventListener("input", function() {
        // Get the input value
        let rate = serviceRateInput.value;

        // Remove non-numeric characters and leading zeroes
        rate = rate.replace(/\D/g, "").replace(/^0+/, "");

        // Format the rate with Philippine Peso sign and commas for thousands separator
        rate =
          "₱" +
          parseFloat(rate).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          });

        // Update the input value
        serviceRateInput.value = rate;
      });
    });
  </script>
</body>

</html>
<?php } else{
header("location:login.php");
}?>