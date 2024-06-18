<?php
// Start a new session or resume the existing one
session_start();

// Check if the cart exists in the session and count the number of items, otherwise set the count to 0
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
  
    <!-- Include the header -->
    <?php include('header.php'); ?>

    <center>
    <br>
    <div class="slideshow-container">
        <!-- Slide 1 -->
        <div class="mySlides fade">
            <img src="IMG/nvidiacard.png" style="width:50%">
        </div>
        <!-- Slide 2 -->
        <div class="mySlides fade">
            <img src="IMG/amdcard.png" style="width:50%">
        </div>
        <!-- Slide 3 -->
        <div class="mySlides fade">
            <img src="IMG/intelcard.png" style="width:50%" >
        </div> 
        <!-- Navigation dots -->
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
</div>

<script>
    // Add event listener to user menu
    document.getElementById('userMenu').addEventListener('click', function() {
        // Display the user popup when the user menu is clicked
        document.getElementById('userPopup').style.display = 'block';
    });

    // Function to close the user popup
    function closePopup() {
        document.getElementById('userPopup').style.display = 'none';
    }

    // Close the user popup when clicking outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById('userPopup')) {
            document.getElementById('userPopup').style.display = 'none';
        }
    }
</script>
<script src="script.js"></script>
</html>