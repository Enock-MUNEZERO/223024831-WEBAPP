<!DOCTYPE html>
<html>

<head>
    <title>Gallery</title>

    <style>
    /* RESET */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        min-height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('valeriia-bugaiova-_pPHgeHz1uk-unsplash');
        background-size: cover;
        background-position: center;
        color: white;
    }

    /* BACKGROUND SLIDER (same as login page) */
    .bg-slider {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }

    .bg-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .bg-slide.active {
        opacity: 1;
        z-index: 1;
    }

    /* Dark overlay for better text visibility */
    .bg-slider::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.65);
        z-index: 2;
    }

    .header {
        position: absolute;
        width: 100%;
        top: 0;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 30px;
       background:#CD853F;
        color: white;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        font-size:25px;
    }

    .nav a {
        color: white;
        margin: 10px;
        font-size:20px;
        text-decoration: none;
        font-weight: bold;
        color:#FFFF00;
        font-family:arial;
    }

    .nav a:hover {
        color:white;
        font-family:arial;
    }

    /* ✅ ADD THIS (YOU MISSED IT) */
    .gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 120px 40px;
    }

    /* IMAGE BOX */
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        height: 250px;
        /* FIXED HEIGHT */
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* ✅ FIXED IMAGE */
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* VERY IMPORTANT */
        transition: 0.5s;
    }

    /* HOVER OVERLAY */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        opacity: 0;
        transition: 0.5s;
    }

    /* HOVER EFFECT */
    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    /* FOOTER */
    .footer {
        background: #523a23de;
        color: white;
        text-align: center;
        padding: 20px;
        position: relative;
        z-index: 10;
        width: 100%;
    }

    /* RESPONSIVE */
    @media(max-width:900px) {
        .gallery {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:600px) {
        .gallery {
            grid-template-columns: 1fr;
        }
    }
    </style>

</head>

<body>

     <!-- BACKGROUND SLIDER (same images from login page) -->
    <div class="bg-slider">
        <div class="bg-slide active" style="background-image: url('heaven-restaurant-boutique.jpg');"></div>
        <div class="bg-slide" style="background-image: url('pic.jpg');"></div>
        <div class="bg-slide" style="background-image: url('enis-yavuz-yy4rMNaL6fw-unsplash.jpg');"></div>
        <div class="bg-slide" style="background-image: url('pool6.jpg');"></div>
        <div class="bg-slide" style="background-image: url('jose-marroquin-vU7MuUlgsQQ-unsplash.jpg');"></div>
    </div>


    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            SILVER Hotel
        </div>
        <div class="nav">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="menu.php">Menu</a>
            <a href="loginorder.php">Order</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>

    <!-- GALLERY -->
    <div class="gallery">

        <a href="order.php" class="gallery-item">
            <img src="Sugary drinks as a child may lead to memory issues in later life.jpg">
            <div class="overlay">Order Soda Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="Air Fryer Rotisserie Chicken.jpg">
            <div class="overlay">Order Chicken Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="download (36).jpg">
            <div class="overlay">Order Beef Steak Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="22.jpg">
            <div class="overlay">Order Flesh Juice Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="pepperoni pizza slice cheese pull pizzeria.jpg">
            <div class="overlay">Order Pizza Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="Cup-Of-Creamy-Coffee.png">
            <div class="overlay">Order Coffee Now</div>
        </a>

         <a href="order.php" class="gallery-item">
            <img src="images (1).jpg">
            <div class="overlay">Order Fish Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="ᴋᴏɸᴇᴇᴋ).jpg">
            <div class="overlay">Order coffee Now</div>
        </a>

        <a href="order.php" class="gallery-item">
            <img src="44.jpg">
            <div class="overlay">Order Chicken Now</div>
        </a>


    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Contact: +250 788354678 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>© 2026 Golden Horizon Hotel. All rights reserved.</p>
    </div>

</body>

</html>