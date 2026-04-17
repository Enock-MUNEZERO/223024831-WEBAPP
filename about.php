<!DOCTYPE html>
<html>

<head>
    <title>About Us</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
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
        font-size: 28px;
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

    /* CONTAINER */
    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 120px 50px;
        gap: 40px;
    }

    /* IMAGE GROUP (UPDATED) */
    .about-image {
        flex-direction: cell;
        gap: 50px;
    }

    .about-image img {
        display: 50px;
        width: 290px;
        height: 190px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        object-fit: cover;
    }

    /* TEXT RIGHT */
    .about-text {
        max-width: 500px;
    }

    .about-text h1 {
        font-size: 40px;
        color: #1E90FF;
        margin-bottom: 20px;
    }

    .about-text p {
        font-size: 18px;
        margin-bottom: 10px;
        line-height: 1.6;
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
    @media(max-width:768px) {
        .container {
            flex-direction: column;
            text-align: center;
        }

        .about-image img {
            width: 100%;
            height: auto;
        }
    }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            SILVER HOTEL
        </div>
        <div class="nav">
            <a href="home.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="gallery.php">Gallery</a>
            <a href="loginorder.php">Order</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>

    <!-- UPDATED CONTENT -->
    <div class="container">

        <!-- IMAGE LEFT (NOW TWO IMAGES) -->
        <div class="about-image">
            <p>
            <img src="heaven-restaurant-boutique.jpg" alt="Hotel Image">
            <img src="jose-marroquin-vU7MuUlgsQQ-unsplash.jpg" alt="Hotel Interior">
            <img src="Virunga-mountains-in-DR-Congo.jpg" alt="Hotel Interior">
            </p>
            <p>
            <img src="heaven-restaurant-boutique.jpg" alt="Hotel Image">
            <img src="jose-marroquin-vU7MuUlgsQQ-unsplash.jpg" alt="Hotel Interior">
            <img src="Virunga-mountains-in-DR-Congo.jpg" alt="Hotel Interior">
            </p>
        </div>

        <!-- TEXT RIGHT -->
        <div class="about-text">
            <h1>About SILVER Hotel</h1>
            <p>SILVER Hotel is located in Musanze-Kinigi. 
                We are surrounded by the natural beauty of the Virunga Mountains, giving our guests a calm and relaxing environment.</p>
            <p>We offer comfortable rooms, tasty meals, and a peaceful place to rest. 
                Whether you come for travel, business, or relaxation, we are here to make your stay enjoyable.</p>
            <p>At SILVER Hotel, we focus on:

Clean and comfortable accommodation,
Fresh and delicious food,
Friendly and helpful service,
A quiet and relaxing atmosphere.

Our goal is to give every guest a good experience and make them feel at home.</p>
            <p>When you stay with us, you are always welcome.</p>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Contact: +250 788354678 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>© 2026 Golden Horizon Hotel. All rights reserved.</p>
    </div>

</body>

</html>