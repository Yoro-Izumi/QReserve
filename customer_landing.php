<?php
include "connect_database.php";
include "src/get_data_from_database/get_services.php";
date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bevitore Sta Rosa</title>
  <link rel="stylesheet" href="src/css/style.css">
  <link rel="stylesheet" href="src/css/landing.css">

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


  <!-- Montserrat Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">


</head>

<body class="customer-landing">
  <header>
    <nav class="navbar">
      <img src="src/images/Bevitore-logo.png" id="customer-landing-logo" />
      <input type="checkbox" id="menu-toggler">
      <label for="menu-toggler" id="hamburger-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
          <path d="M0 0h24v24H0z" fill="none" />
          <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
        </svg>
      </label>
      <ul class="all-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#amenities">Amenities</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#contact">Contact Us</a></li>
      </ul>
    </nav>
  </header>

  <section class="homepage" id="home">
    <div class="content">
      <div class="text">
        <h1 class="qreserve mb-0" id="customer-index">QReserve</h1>
        <h5 class="bevitore">BEVITORE SANTA ROSA</h5>
      </div>
      <a href="customer_login.php" id="landing-button">BOOK NOW</a>
    </div>
  </section>

  <section class="services" id="services">
      <h2>Our Services</h2>
      <!-- <p>Explore our wide range of camping gear services.</p> -->
      <ul class="cards">
        <li class="card">
          <img src="src/images/Services/Billiards Hall.jpg" alt="img">
          <h3>Billiards</h3>
          <p>Rate: ₱150/hr</p>
        </li>
        <li class="card">
          <img src="src/images/Services/KTV Room 1.jpg" alt="img">
          <h3>KTV Room 1</h3>
          <p>Rate: ₱5000/2hrs</p>
        </li>
        <li class="card">
          <img src="src/images/Services/KTV Room 2.jpg" alt="img">
          <h3>KTV Room 2</h3>
          <p>Rate: ₱3000/2hrs</p>
        </li>
        <li class="card">
          <img src="src/images/Services/KTV Room 3.jpg" alt="img">
          <h3>KTV Room 3</h3>
          <p>Rate: ₱3000/2hrs</p>
        </li>
        <li class="card">
          <img src="src/images/Services/Karaoke.jpg" alt="img">
          <h3>Karaoke Night</h3>
          <p>Rate: Free</p>
        </li>
        <li class="card">
          <img src="src/images/Services/Membership.jpg" alt="img">
          <h3>Membership</h3>
          <p>Rate: 250</p>
        </li>
      </ul>
    </section>

  <section class="amenities" id="amenities">
    <h2>Amenities</h2>
    <ul class="cards">
      <li class="card">
        <img src="src/images/Services/Billiards Hall.jpg" alt="img">
      </li>
      <li class="card">
        <img src="src/images/Pubmats/434349874_384753677778942_8332027815166046702_n.jpg" alt="img">
      </li>
      <li class="card">
        <img src="src/images/Pubmats/434361833_384754844445492_7151520115554376035_n.jpg" alt="">
      </li>
      <li class="card">
        <img src="src/images/Pubmats/434190531_386131807641129_6896777236919307809_n.jpg" alt="">
      </li>
      <li class="card">
        <img src="src/images/Pubmats/434349874_384753677778942_8332027815166046702_n.jpg" alt="">
      </li>
      <li class="card">
        <img src="src/images/Pubmats/434361833_384754844445492_7151520115554376035_n.jpg" alt="">
      </li>
    </ul>
  </section>


  <section class="about" id="about">
    <h2>About Us</h2>
    <div class="row company-info">
      <h3>Our Story</h3>
      <p>Bevitore Santa Rosa is a relaxed venue where patrons can unwind, socialize, and spend time with friends and family. It offers opportunities for singing, dancing, drinking, and recreational activities, fostering the creation of lasting memories</p>
    </div>
    <!-- <div class="row mission-vision">
        <h3>Our Mission</h3>
        <p>At Camping Gear Experts, our mission is to equip outdoor enthusiasts with top-notch camping gear and essentials that enhance their outdoor experiences. We strive to provide reliable, durable, and innovative products that contribute to memorable adventures and lasting memories.</p>
        <h3>Our Vision</h3>
        <p>Our vision is to become the go-to destination for camping enthusiasts, known for our extensive selection of premium camping gear and exceptional customer service. We aspire to inspire and enable people to embrace the beauty of nature and create unforgettable camping experiences.</p>
      </div> -->
    <!-- <div class="row team">
        <h3>Our Team</h3>
        <ul>
          <li>John Doe - Founder and CEO</li>
          <li>Jane Smith - Gear Specialist</li>
          <li>Mark Johnson - Customer Representative</li>
          <li>Sarah Brown - Operations Manager</li>
        </ul>
      </div> -->
  </section>

  <section class="contact" id="contact">
    <h2>Contact Us</h2>
    <div class="row">
      <div class="col information">
        <div class="contact-details">
          <p><i class="fas fa-map-marker-alt"></i> 2nd Floor Victory Central Mall Sta Rosa, Balibago Complex,Sta Rosa City, Laguna</p>
          <p><i class="fas fa-envelope"></i> bevitore.inquiries2022@gmail.com</p>
          <p><i class="fas fa-clock"></i> Sunday - Tuesday: 10AM - 1AM</p>
          <p><i class="fas fa-clock"></i> Wednesday - Saturday: 10AM - 3AM</p>
          <p><i class="fab fa-facebook"></i> www.facebook.com/Bevitore.Sta.Rosa</p>
        </div>
      </div>
      <div class="col form">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3866.3311061967775!2d121.1001308758709!3d14.29218458455158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d96d5e79b44d%3A0xf3bc2aea1c1e6f4e!2sBevitore%20Sta.%20Rosa!5e0!3m2!1sen!2sph!4v1712407493936!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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



  
  </section>
  

  <footer>
    <div>
      <span>Copyright © 2024 All Rights Reserved</span>
      <span class="link">
        <a href="#">Home</a>
        <a href="#contact">Contact</a>
      </span>
    </div>
  </footer>

</body>

</html>