// Initialize the slide index and slide timeout variables
let slideIndex = 0;
let slideTimeout;

// Call the showSlides function to start the slideshow
showSlides();

// Define the showSlides function
function showSlides() {
    let i;
    // Get all the slides and dots elements
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Hide all the slides
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Increment the slide index
    slideIndex++;

    // If the slide index is greater than the number of slides, reset it to 1
    if (slideIndex > slides.length) {slideIndex = 1}

    // Remove the active class from all the dots
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Display the current slide and add the active class to the current dot
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";

    // Set a timeout to automatically change the slide every 7 seconds
    slideTimeout = setTimeout(showSlides, 7000);
}

// Define the currentSlide function
function currentSlide(n) {
    // Clear the slide timeout to stop the automatic slideshow
    clearTimeout(slideTimeout);

    // Set the slide index to the passed in value
    slideIndex = n;

    // Call the showSlides function to update the displayed slide
    showSlides();
}

// Define the goToIndex function
function goToIndex() {
    // Redirect the user to the index page
    window.location.href = 'index.php';
}