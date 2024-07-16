<?php
session_start();

// Check if the user is authenticated
if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // If authenticated, determine which dashboard link to display
    if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        // If admin, set the admin dashboard link
        $dashboardLink = '<li><a href="./dashboard.php">Admin Dashboard</a></li>';
    } else {
        // If member, set the member dashboard link
        $dashboardLink = '<li><a href="./member_dashboard.php">Dashboard</a></li>';
    }
} else {
    // If not authenticated, set the login link
    $dashboardLink = '<li><a id="login" href="./login.php">LOG IN</a></li>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AMA | Fitness Club</title>

  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Protest+Revolution&display=swap" rel="stylesheet">



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
    integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <!-- __________header___________ -->

  <div id="landing_img">
    <section id="header">
      <div class="logo-container">
        <h3>FITNESS CLUB</h3>
      </div>

      <ul id="navbar">
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#plans">Plans</a></li>
        <li><a href="#Trainers">Trainers</a></li>
        <li><a href="#about-us">About us</a></li>
        <?php echo $dashboardLink; ?>
      </ul>
    </section>

    <section id="landing">
      <h4>Welcome to</h4>
      <h2>Fitness Club</h2>
      <p>Get fit, stay healthy, and achieve your fitness goals with us!</p>
      <a href="#classes"><button class="white">Explore Plans</button></a>
    </section>
  </div>
  <button id="goToTopBtn" onclick="goToTop()">
    <i class='fas fa-chevron-up'></i>
  </button>

  <!-- __________packages-section___________ -->
  <section class="package_section" id="plans">
    <div class="main flow">
      <h1 class="main__heading">Our Packages</h1>
      <!-- <div class="main__cards cards"> -->
      <div class="cards__inner">
        <div class="cards__card card">
          <h2 class="card__heading">Basic</h2>
          <p class="card__price">$9.99</p>
          <ul role="list" class="card__bullets flow">
            <li>Access to standard workouts and nutrition plans</li>
            <li>Email support</li>
          </ul>
          <a href="#basic" class="card__cta cta">Get Started</a>
        </div>

        <div class="cards__card card">
          <h2 class="card__heading">Pro</h2>
          <p class="card__price">$19.99</p>
          <ul role="list" class="card__bullets flow">
            <li>Access to advanced workouts and nutrition plans</li>
            <li>Priority Email support</li>
            <li>Exclusive access to live Q&A sessions</li>
          </ul>
          <a href="#pro" class="card__cta cta">Upgrade to Pro</a>
        </div>

        <div class="cards__card card">
          <h2 class="card__heading">Ultimate</h2>
          <p class="card__price">$29.99</p>
          <ul role="list" class="card__bullets flow">
            <li>Access to all premium workouts and nutrition plans</li>
            <li>24/7 Priority support</li>
            <li>1-on-1 virtual coaching session every month</li>
            <li>Exclusive content and early access to new features</li>
          </ul>
          <a href="#ultimate" class="card__cta cta">Go Ultimate</a>
        </div>
      </div>

      <div class="overlay cards__inner"></div>
      <!-- </div> -->
    </div>
  </section>





  <!-- _________services-box______________  -->

  <section id="services" class="section-p1">
    <h3>Our Services</h3>
    <div class="fe-box">
      <img src="./image/services/s1.jpg" alt="img" />
      <h6>Personal Training</h6>
    </div>
    <div class="fe-box">
      <img src="./image/services/s2.jpg" alt="img" />
      <h6>Group Classes</h6>
    </div>

    <div class="fe-box">
      <img src="./image/services/s4.jpg" alt="img" />
      <h6>Swimming pool</h6>
    </div>
    <div class="fe-box">
      <img src="./image/services/s3.jpg" alt="img" />
      <h6>Nutritional Counseling</h6>
    </div>
  </section>

  <!-- _______________workout-card_____________ -->

  <section class="gallary mtop" id="gallary">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading1">
          <h2>Equipments</h2>
        </div>
      </div>

      <div class="owl-carousel owl-theme" id="workout-carousel">

        <?php include 'connection.php';

        $selectQuery = "SELECT * FROM equipment";
        $result = mysqli_query($con, $selectQuery);

        if ($result && mysqli_num_rows($result) > 0) {

          while ($record = mysqli_fetch_assoc($result)) {
            echo "<div class='item'>
  <div class='pro'>
  <a href='#'>
    <img src='".substr($record['photo'], 6)."' alt='workout-img' />
    <div class='des'>
    <span>{$record['name']}</span>
      </div>
      </a>
      </div>
      </div>";
          }

        } else {
          echo "<p class='text-center'>No records found.</p>";
        }

        ?>

      </div>
    </div>
  </section>

  <section class="ad">
    <div class="upper-ad">
      <div class="video-container">
        <video src="./image/ad/ad2.mp4" loop="true" autoplay="true" muted></video>
        <div class="text-overlay">
          <h1>A easy and safer method of exercising</h1>
          <p>
            a workout program that supports you, simplifies things,and keeps
            you safe so you feel powerful and energetic
          </p>
        </div>
      </div>
    </div>

    <div class="lower-ad">
      <h2>Our Plan Types</h2>
      <div class="box">
        <div class="box1">
          <h4>Monthly</h4>
          <img src="./image/mny.png" alt="" width="30px" height="30px" />
          <span>Enjoy unlimited gym access every month for a set fee, perfect for
            regular gym enthusiasts seeking value and convenience.</span>
        </div>
        <div class="box2">
          <h4>Yearly</h4>
          <img src="./image/pay.png" alt="" width="30px" height="30px" />
          <span>Commit to a yearly gym membership and access to gym services throughout the year. Ideal for those seeking cost-effectiveness and frequent payments</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Trainers section -->
  <section id="Trainers" class="section-p1">
    <div class="heading_top flex1">
      <div class="heading2">
        <h2>Our Experianced Trainers</h2>
      </div>
      <div class="owl-carousel owl-theme" id="trainer-carousel">
        <?php include 'connection.php';

        $selectQuery = "SELECT * FROM trainer";
        $result = mysqli_query($con, $selectQuery);

        if ($result && mysqli_num_rows($result) > 0) {

          while ($record = mysqli_fetch_assoc($result)) {
            echo "<div class='item'>
          <div class='trainer'>
            <img src='".substr($record['photo'], 6)."' alt='Trainer'/>
            <div class='trainer-details'>
            <h4>{$record['full_name']}</h4>
              <p>{$record['specialization']}</p>
              </div>
              </div>
              </div>";
          }

        } else {
          echo "<p class='text-center'>No records found.</p>";
        }

        ?>
      </div>
  </section>

  <section id="about-us" class="section">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h2>About Us</h2>
          <p>We are dedicated to helping you achieve your fitness goals by providing top-notch training programs,
            personalized guidance, and a supportive community atmosphere.</p>
          <p>At our fitness club, we believe in holistic wellness, focusing on both physical and mental health to help
            you lead a balanced and fulfilling life.</p>
        </div>
        <div class="about-image">
          <img src="./image//back11-removebg-preview.png" alt="About Us Image">
        </div>
      </div>
    </div>
  </section>

  <section class="footer">
    <div class="upper-footer">

      <div class="upper-footer-l">
        <div class="about">
          <span>About</span>
          <a href="">Our story</a>
          <a href="">Our team</a>
          <a href="#">Testimonials</a>
          <a href="#">Blog</a>
          <a href="#">FAQ</a>
        </div>

        <div class="learn">
          <span>learn</span>
          <a href="">workout plans</a>
          <a href="">Trainers</a>
        </div>

        <div class="account">
          <span>Account</span>
          <a href="#">Sign Up</a>
          <a href="#">Log In</a>
          <a href="#">Membership</a>
          <a href="#">Schedule</a>
          <a href="#">Contact</a>
        </div>
      </div>

      <div class="upper-footer-r">
        <div class="upper-footer-r-col1">
          <span style="display: block;">Lets Stay Connected</span>
          <span style="color: #fff;">Enter your email to get 5% OFF</span>
          <form action="">
            <input type="email" name="" id="">
            <button>SUBMIT</button>
          </form>

        </div>

        <div class="upper-footer-r-col2">
          <span style="display: block; font-weight: 600;font-size: 18px; color: #fff;">Follow us</span>
          <a href="#" class="fa fa-facebook"></a>
          <a href="#" class="fa fa-google"></a>
          <a href="#" class="fa fa-instagram"></a>
          <a href="#" class="fa fa-twitter"></a>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>&copy;2024 Fitness Club,Inc All Rights Reserved</p>
    </div>
  </section>







  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
    integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(".owl-carousel").owlCarousel({
      loop: false,
      margin: 10,
      nav: true,
      dots: false,
      navText: [
        "<i class='fas fa-chevron-left'></i>",
        "<i class='fas fa-chevron-right'></i>",
      ],
      responsive: {
        0: {
          items: 1,
        },
        768: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    });
  </script>

  <script>
    $(document).ready(function () {
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        responsive: {
          0: {
            items: 1,
          },
          768: {
            items: 2,
          },
          1000: {
            items: 3,
          },
        },
      });
    });
  </script>

  <script>
    window.onscroll = function () { scrollFunction() };

    function scrollFunction() {
      var goToTopBtn = document.getElementById("goToTopBtn");
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        goToTopBtn.style.display = "block";
      } else {
        goToTopBtn.style.display = "none";
      }
    }

    function goToTop() {
      var scrollToTop = window.setInterval(function () {
        var pos = window.pageYOffset;
        if (pos > 0) {
          window.scrollTo(0, pos - 20); // how far to scroll on each step
        } else {
          window.clearInterval(scrollToTop);
        }
      }, 8); // how often to scroll (in milliseconds)
    }

    document.addEventListener("DOMContentLoaded", function () {
      const packageCards = document.querySelectorAll(".package-card");

      packageCards.forEach((card) => {
        card.addEventListener("click", function () {
          // Toggle active class to show/hide details
          this.classList.toggle("active");
        });
      });
    });




  </script>
</body>

</html>