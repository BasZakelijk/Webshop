<?php
session_start();
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GraphicsLand - Home</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<title>Responsive Card Slider</title>-->

    <!-- Swiper CSS -->

</head>
<body>
  
    <!-- Navbar -->
    <?php include('header.php'); ?>


      <center>
      <br>
      <div class="slideshow-container">
      <div class="mySlides fade">
          <img src="IMG/nvidiacard.png" style="width:50%">
      </div>
      <div class="mySlides fade">
          <img src="IMG/amdcard.png" style="width:50%">
      </div>
      <div class="mySlides fade">
          <img src="IMG/intelcard.png" style="width:50%" >
      </div> 
      <div class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        </div>
      </div>
      <br>
    </center>
</body>
<!-- Popup for logged-in user options -->
<div id="userPopup" class="popup">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        <div class="popup-header">Welcome, <a id="userMenu"><?php echo htmlspecialchars($_SESSION['username']); ?></a></div>
        <button onclick="window.location.href='logout.php'">Logout</button>
        <button onclick="window.location.href='purchase_history.php'">Purchase History</button>
    </div>

    <script>
        document.getElementById('userMenu').addEventListener('click', function() {
            document.getElementById('userPopup').style.display = 'block';
        });

        function closePopup() {
            document.getElementById('userPopup').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('userPopup')) {
                document.getElementById('userPopup').style.display = 'none';
            }
        }
        </script>
<script src="script.js"></script>
</html>