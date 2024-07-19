<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bevitore Sta Rosa</title>

  <!-- <link rel="stylesheet" href="src/css/landing.css"> -->
  <link rel="stylesheet" href="src/css/style.css">

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Montserrat Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  <link rel="stylesheet" href="src/loader/loader.css">
</head>
<body class="index-landing">

<?php
if ($_SERVER['HTTP_HOST'] === 'qreserve.site') {
    header('Location: customer_landing.php');
    exit;
}
?>

<!-- <?php include "src/loader/loader.html"; ?> -->
<div class="container-fluid homepage">
  <div class="home">
    <img src="src/images/Bevitore Billiards Hall Logo.png" alt="Bevitore Logo" class="bevitore-logo">
    <h1 class="qreserve" id="index-qreserve">QReserve</h1>
    <h6 class="bevitore">BEVITORE SANTA ROSA</h6>
    <a href="login.php" type="button" class="btn btn-primary fw-bold start-button" id="index-button">Click to start session</a>
  </div>
</div>

<div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
<script>
  $(document).ready(function() {
    // Function to update table content
    function updateTable() {
      $.ajax({
        url: 'pool_table.php',
        type: 'GET',
        success: function(response) {
          $('#updateTable').html(response);
        }
      });
    }

    // Initial table update
    updateTable();

    // Refresh table every 5 seconds
    setInterval(updateTable, 1000); // Adjust interval as needed
  });
</script> 

  <script>
      function executePHP() {
          var xhr = new XMLHttpRequest();
          xhr.open('GET', 'delete_member_notification.php', true);
          xhr.send();
          xhr.onload = function() {
              if (xhr.status != 200) {
                  console.error(`Error ${xhr.status}: ${xhr.statusText}`);
              } else {
                  console.log(`Done, response received: ${xhr.response}`);
              }
          };
          xhr.onerror = function() {
              console.error('Request failed');
          };
      }

      setInterval(executePHP, 4000);
  </script>
  
<script src="src/loader/loader.js"></script>

</body>
</html>
