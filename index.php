<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Market</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-5/assets/css/hero-5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
 <!-- Navigation Container -->
 <div class="nav">
    <nav>
        <ul>   
            <li><a href="index.php">𝐇𝐨𝐦𝐞</a></li>
            <li><a href="#about-us">𝐀𝐛𝐨𝐮𝐭</a></li>
            <li><a href="#featured-products">𝐄𝐱𝐩𝐥𝐨𝐫𝐞</a></li>
            <li><a href="#contact">𝐂𝐨𝐧𝐭𝐚𝐜𝐭</a></li>
            <li><a href="v.php">𝐉𝐨𝐢𝐧 𝐚𝐬 𝐚 𝐕𝐞𝐧𝐝𝐨𝐫</a></li>
        </ul>
    </nav>
</div>


    <!-- Hero Banner -->
    <section class="hero-section">
        <div class="owl-carousel owl-theme hero-carousel">
            <div class="item"><img src="img/1.jpg" alt="Image 1"></div>
            <div class="item"><img src="img/2.jpg" alt="Image 2"></div>
            <div class="item"><img src="img/3.jpg" alt="Image 3"></div>
            <div class="item"><img src="img/4.jpg" alt="Image 4"></div>
        </div>
        <div class="hero-content">
            <h2 class="display-1 text-white text-center fw-bold mb-4">𝐁𝐡𝐨𝐨𝐦𝐢𝐁𝐚𝐬𝐤𝐞𝐭</h2>
            <p class="typing-text">
                <span class="line">From farm to your doorstep!</span>
                <span class="line">ক্ষেত থেকে সোজা আপনার কাছে!</span>
                <span class="line">खेत से सीधा आपके दरवाजे तक!</span>
            </p>
        </div>
    </section>
    
<!-- Botpress Chatbot Scripts -->
<script src="https://cdn.botpress.cloud/webchat/v2/inject.js"></script>
<script src="https://mediafiles.botpress.cloud/0beb1456-0afa-4bf0-8967-8dfcad93eeee/webchat/v2/config.js"></script>

<!-- About Section -->
<section id="about-us" class="pt-5 pb-5">
    <div class="container wrapabout">
        <div class="red"></div>
        <div class="row">
            <div class="col-lg-6 align-items-center justify-content-left d-flex mb-5 mb-lg-0">
                <div class="blockabout">
                    <div class="blockabout-inner text-center text-sm-start">
                        <div class="about" style="color: black; font-weight: bold; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);">
                            <h3>ABOUT US</h3>
                        </div>
                        <p class="about" style="color: black; font-weight: bold; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);">
                            We connect local farmers with customers who want fresh, seasonal produce. Our platform ensures that you have access to high-quality products directly from the source.
                        </p>
                        <p class="about" style="color: black; font-weight: bold; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);">
                            Explore our market to find the best seasonal produce and support local agriculture.
                        </p>
   
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <figure class="potoaboutwrap">
                    <video autoplay muted playsinline width="100%">
                        <source src="img/about.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </figure>
            </div>
        </div>

    </div>
</section>



<!-- JavaScript to Open Chatbot on Click -->
<script>
document.getElementById("chatbot-logo").addEventListener("click", function() {
    window.botpressWebChat.init();
});
</script>


    <!-- New Section (e.g., Featured Products) -->
    <section id="featured-products" class="pt-5 pb-5">
        <div class="container">
            <h2 class="text-center mb-4">𝐓𝐚𝐳𝐢 𝐕𝐞𝐠𝐞𝐭𝐚𝐛𝐥𝐞 𝐒𝐞𝐜𝐭𝐢𝐨𝐧!</h2>
            <div class="owl-carousel owl-theme">
                <div class="item card card-has-bg" style="background-image: url('img/gajar.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Taza Gajar</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/tomato.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Mast Tamatar</h5>
                        <p class="card-meta">Organic</p>
                        <p class="card-text">Crunchy and sweet carrots grown with love and care.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/SM.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Rangeen Shimla </h5>
                        <p class="card-meta">Organic</p>
                        <p class="card-text">Crunchy and sweet carrots grown with love and care.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/bhin.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Swadila Bhindi</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/matar.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Taza Matar</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>


                <!-- Add more items as needed -->
            </div>
            <a href="USER/user.php" class="arrow-btn"></a>
    
        </div>
    </section>
    <section id="featured-products" class="pt-5 pb-5">
        <div class="container">
            <h2 class="text-center mb-4">𝐓𝐚𝐳𝐞 𝐅𝐫𝐮𝐢𝐭 𝐒𝐞𝐜𝐭𝐢𝐨𝐧!</h2>
            <div class="owl-carousel owl-theme">
                <div class="item card card-has-bg" style="background-image: url('img/orange.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Lajawab Santara</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/tarbooj.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Raseela Tarbooj</h5>
                        <p class="card-meta">Organic</p>
                        <p class="card-text">Crunchy and sweet carrots grown with love and care.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/apple.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Swadisht Seb</h5>
                        <p class="card-meta">Organic</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/aam.jpg');">
                    <div class="card-body">
                        <h5 class="card-title">Shahi Aam</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                <div class="item card card-has-bg" style="background-image: url('img/papa.jpeg');">
                    <div class="card-body">
                        <h5 class="card-title">Pyari Papaya</h5>
                        <p class="card-meta">Seasonal</p>
                        <p class="card-text">Delicious and juicy apples straight from local orchards.</p>
                    </div>
                </div>
                
                <!-- Add more items as needed -->
            </div>
            <a href="USER/user.php" class="arrow-btn"></a>
        </div>
        
    </section>

    <div style="width: 100%; overflow: hidden;">
    <img src="img/offer.png" alt="OFFER" style="width: 100%; height: auto; display: block;">
</div>
    <div style="width: 100%; overflow: hidden;">
    <img src="img/FtoH.png" alt="SERVICE" style="width: 100%; height: auto; display: block;">
</div>



<body>
    <div style="width: 100%; text-align: center; padding: 20px;">
        <div style="display: flex; justify-content: space-around; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 150px; padding: 10px;">
                <h3 id="happy-customers" style="font-size: 24px; margin: 0; color: #333;">0</h3>
                <p style="font-size: 18px; margin: 0;">Happy Customers</p>
            </div>
            <div style="flex: 1; min-width: 150px; padding: 10px;">
                <h3 id="farmers-supported" style="font-size: 24px; margin: 0; color: #333;">0</h3>
                <p style="font-size: 18px; margin: 0;">Farmers Supported</p>
            </div>
            <div style="flex: 1; min-width: 150px; padding: 10px;">
                <h3 id="partners-onboarded" style="font-size: 24px; margin: 0; color: #333;">0</h3>
                <p style="font-size: 18px; margin: 0;">Partners Onboarded</p>
            </div>
            <div style="flex: 1; min-width: 150px; padding: 10px;">
                <h3 id="orders-till-date" style="font-size: 24px; margin: 0; color: #333;">0</h3>
                <p style="font-size: 18px; margin: 0;">Orders Till Date</p>
            </div>
        </div>
    </div>

    <script>
        function animateCounter(id, endValue, duration) {
            let startValue = 0;
            const element = document.getElementById(id);
            const increment = endValue / (duration / 20);
            
            const updateCounter = () => {
                startValue += increment;
                if (startValue >= endValue) {
                    element.textContent = endValue.toLocaleString() + '+';
                } else {
                    element.textContent = Math.floor(startValue).toLocaleString() + '+';
                    setTimeout(updateCounter, 100);
                }
            };

            updateCounter();
        }
        // Start the counters
        animateCounter('happy-customers', 1000000, 7000);
        animateCounter('farmers-supported', 20000, 7000);
        animateCounter('partners-onboarded', 1000, 7000);
        animateCounter('orders-till-date', 10000000, 7000);
    </script>
</body>




    
    <footer class="footer" id="contact">

<!-- Widgets Section -->
<div class="bg-light py-3 py-md-5 py-xl-8 border-top border-light-subtle">
    <div class="container overflow-hidden">
        <div class="row gy-3 gy-md-5 gy-xl-0 text-center">

            <!-- Logo Section -->
            <div class="col-xs-12 col-sm-6 col-xl-3 order-1 order-xl-1">
                <div class="footer-logo-wrapper">
                    <a href="index.php">
                        <img src="img/Blogo.png" alt="Logo" width="140" height="140" style="max-width: 100%; height: auto;">
                    </a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-xs-12 col-xl-6 order-2 order-xl-2">
    <div class="footer-copyright-wrapper" style="text-align: center;">
        <p style="margin-bottom: 5px;">𝐎𝐟𝐟𝐢𝐜𝐞: 𝙽𝚎𝚠 𝚃𝚘𝚠𝚗. 𝙺𝚘𝚕𝚔𝚊𝚝𝚊- 𝟽𝟶𝟶𝟷𝟻𝟼</p>
        <p style="margin-bottom: 5px;">𝐖𝐨𝐫𝐤𝐢𝐧𝐠 𝐇𝐨𝐮𝐫𝐬: 𝟷𝟶𝙰𝙼 - 𝟼𝙿𝙼 𝙼𝚘𝚗 - 𝚂𝚊𝚝</p>
        <p style="margin-bottom: 5px;">𝐂𝐚𝐥𝐥: 8095051600</p>
        <p style="margin-bottom: 5px;">𝐄𝐦𝐚𝐢𝐥: 𝚑𝚎𝚕𝚕𝚘@𝚋𝚑𝚘𝚘𝚖𝚒.𝚒𝚗</p>
        <p>𝘋𝘦𝘷𝘦𝘭𝘰𝘱𝘦𝘳'𝘴 𝘢𝘥𝘥𝘳𝘦𝘴𝘴: 𝘉𝘢𝘴𝘪𝘳𝘩𝘢𝘵- 74311</p>
        <p>Built by 𝐏𝐀𝐋𝐀𝐒𝐇 𝐊𝐔𝐍𝐃𝐔
        <span class="text-primary">&#9829;</span></p>
    </div>
</div>


            <!-- Social Media Links -->
            <div class="col-xs-12 col-sm-6 col-xl-3 order-3 order-xl-3">
                <div class="social-media-wrapper text-center">
                    <ul class="list-unstyled m-0 p-0 d-flex justify-content-center">
                        <li class="me-3">
                            <a href="#!" class="link-dark link-opacity-75-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                </svg>
                            </a>
                        </li>
                        <li class="me-3">
                            <a href="#!" class="link-dark link-opacity-75-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                    <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                </svg>
                            </a>
                        </li>
                        <li class="me-3">
                            <a href="#!" class="link-dark link-opacity-75-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#!" class="link-dark link-opacity-75-hover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.445.445.89.719 1.416.923.510.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

</footer>




    <!-- jQuery and Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
