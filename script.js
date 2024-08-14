$(document).ready(function () {
    $('.hero-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        items: 1,
        nav: false,
        dots: true,
        loop: true
    });

    // Initialize the other Owl Carousel if needed
    $('.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: false,
        items: 1,
        stagePadding: 20,
        center: true,
        nav: false,
        margin: 50,
        dots: true,
        loop: true,
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            575: { items: 2 },
            768: { items: 2 },
            991: { items: 3 },
            1200: { items: 4 }
        }
    });
});

// Function to scroll to the About Us section
function scrollToAboutUs() {
    const element = document.getElementById('about-us');
    element.scrollIntoView({ behavior: 'smooth' });
}

// Initialize Owl Carousel
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true
    });
});
$(document).ready(function () {
    $('.hero-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        items: 1,
        nav: false,
        dots: true,
        loop: true
    });

    // Initialize the featured products Owl Carousel
    const owl = $('.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: false,
        items: 1,
        stagePadding: 20,
        center: true,
        nav: false,
        margin: 50,
        dots: true,
        loop: true,
        responsive: {
            0: { items: 1 },
            480: { items: 2 },
            575: { items: 2 },
            768: { items: 2 },
            991: { items: 3 },
            1200: { items: 4 }
        }
    });

    // Custom navigation
    $('.carousel-prev').click(function() {
        owl.trigger('prev.owl.carousel');
    });

    $('.carousel-next').click(function() {
        owl.trigger('next.owl.carousel');
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        const lines = document.querySelectorAll('.typing-text .line');
        let currentLine = 0;

        function typeLine(lineElement, callback) {
            lineElement.classList.add('typing'); // Show current line
            const text = lineElement.textContent;
            lineElement.textContent = '';
            let index = 0;

            function type() {
                if (index < text.length) {
                    lineElement.textContent += text.charAt(index);
                    index++;
                    setTimeout(type, 100); // Adjust typing speed here
                } else {
                    setTimeout(() => {
                        lineElement.classList.remove('typing'); // Hide line after typing
                        callback(); // Move to the next line
                    }, 2000); // Pause before moving to the next line
                }
            }

            type();
        }

        function typeAllLines() {
            if (currentLine < lines.length) {
                // Set the current line to be visible and others to be hidden
                lines.forEach((line, index) => {
                    line.style.opacity = index === currentLine ? 1 : 0;
                    line.style.zIndex = index === currentLine ? 1 : -1;
                });

                // Type the current line
                typeLine(lines[currentLine], function () {
                    currentLine++;
                    typeAllLines();
                });
            }
        }

        typeAllLines();
    });

