let slideIndex = 0;
let slideTimeout;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    slideTimeout = setTimeout(showSlides, 7000); // Change image every 7 seconds
}

function currentSlide(n) {
    clearTimeout(slideTimeout);  // Stop the automatic slideshow
    slideIndex = n;
    showSlides();
}
