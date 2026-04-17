<?php
session_start();
include 'db.php';

$success_message = "";
$error_message = "";

if(isset($_POST['send'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Using prepared statement for security
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, location, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $location, $message);
    
    if($stmt->execute()){
        $success_message = "Message sent successfully! We'll get back to you within 24 hours.";
    } else {
        $error_message = "Failed to send message. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SILVER Hotel</title>
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
        position: relative;
        color: white;
    }

    /* BACKGROUND SLIDER */
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
        transition: opacity 1.2s ease-in-out;
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

    /* HEADER with #CD853F */
    .header {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 15;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
        background: #CD853F;
        color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .logo {
        font-size: 28px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .nav a {
        color: #FFFF00;
        margin: 0 12px;
        font-size: 18px;
        text-decoration: none;
        font-weight: bold;
        font-family: Arial, sans-serif;
        transition: all 0.3s;
    }

    .nav a:hover {
        color: white;
    }

    /* USER WELCOME (if logged in) */
    .user-welcome {
        position: fixed;
        top: 90px;
        right: 30px;
        z-index: 15;
        background: rgba(205,133,63,0.95);
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: bold;
        color: #FFFF00;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .user-welcome a {
        color: white;
        margin-left: 10px;
        text-decoration: none;
    }

    .user-welcome a:hover {
        text-decoration: underline;
    }

    /* FORM CONTAINER */
    .form-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 140px;
        padding-bottom: 80px;
        min-height: 100vh;
        position: relative;
        z-index: 10;
    }

    /* FORM DESIGN */
    form {
        background: white;
        color: black;
        width: 450px;
        padding: 35px;
        border-radius: 15px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
        animation: fadeInUp 0.5s ease;
        border-top: 5px solid #CD853F;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #CD853F;
        font-size: 28px;
        border-left: 4px solid #CD853F;
        padding-left: 15px;
    }

    /* INPUT STYLE */
    input,
    textarea {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 15px;
        transition: all 0.3s;
        font-family: Arial, sans-serif;
    }

    textarea {
        height: 120px;
        resize: vertical;
    }

    input:focus,
    textarea:focus {
        outline: none;
        border: 1px solid #CD853F;
        box-shadow: 0 0 5px rgba(205,133,63,0.3);
    }

    /* BUTTON */
    button {
        width: 100%;
        padding: 14px;
        background: #CD853F;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
        transition: all 0.3s;
    }

    button:hover {
        background: #b5702e;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(205,133,63,0.4);
    }

    /* MESSAGE STYLES */
    .success-message {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        animation: slideDown 0.5s ease;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* CONTACT INFO BOX */
    .contact-info {
        background: rgba(205,133,63,0.9);
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .contact-info h3 {
        margin-bottom: 10px;
        font-size: 18px;
        color: #FFFF00;
    }

    .contact-info p {
        margin: 8px 0;
        font-size: 14px;
        color: white;
    }

    /* SUCCESS MODAL */
    .success-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 100;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }

    .success-modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        animation: scaleIn 0.3s ease;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        border-top: 5px solid #CD853F;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal-content .check-icon {
        font-size: 70px;
        color: #28a745;
        margin-bottom: 20px;
    }

    .modal-content h3 {
        color: #CD853F;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .modal-content p {
        color: #333;
        margin: 10px 0;
        line-height: 1.6;
    }

    .modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 25px;
    }

    .modal-buttons button {
        width: auto;
        padding: 10px 25px;
        margin: 0;
        font-size: 14px;
    }

    .btn-ok {
        background: #CD853F;
    }

    .btn-ok:hover {
        background: #b5702e;
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
    .footer p {
        margin: 5px 0;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            padding: 15px;
            gap: 10px;
        }
        
        .logo {
            font-size: 22px;
        }
        
        .nav a {
            margin: 0 8px;
            font-size: 14px;
        }
        
        .user-welcome {
            top: 85px;
            right: 15px;
            font-size: 11px;
            padding: 5px 12px;
        }
        
        .form-container {
            padding-top: 160px;
            padding-bottom: 60px;
        }
        
        form {
            width: 90%;
            padding: 25px;
        }
        
        form h2 {
            font-size: 24px;
        }

        .modal-content {
            padding: 25px;
        }

        .modal-buttons {
            flex-direction: column;
        }

        .modal-buttons button {
            width: 100%;
        }
    }
    </style>
</head>
<body>

    <!-- BACKGROUND SLIDER -->
    <div class="bg-slider">
        <div class="bg-slide active" style="background-image: url('heaven-restaurant-boutique.jpg');"></div>
        <div class="bg-slide" style="background-image: url('pic.jpg');"></div>
        <div class="bg-slide" style="background-image: url('enis-yavuz-yy4rMNaL6fw-unsplash.jpg');"></div>
        <div class="bg-slide" style="background-image: url('pool6.jpg');"></div>
        <div class="bg-slide" style="background-image: url('jose-marroquin-vU7MuUlgsQQ-unsplash.jpg');"></div>
    </div>

    <!-- HEADER with SILVER Hotel -->
    <div class="header">
        <div class="logo">
            SILVER Hotel
        </div>
        <div class="nav">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="menu.php">Menu</a>
            <a href="gallery.php">Gallery</a>
            <a href="loginorder.php">Order</a>
        </div>
    </div>

    <!-- FORM CONTAINER -->
    <div class="form-container">
        <form method="POST" id="contactForm">
            <h2>Contact Us</h2>
            
            <?php if($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <input type="text" name="name" placeholder="Full Name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

            <input type="email" name="email" placeholder="Email Address" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <input type="tel" name="phone" placeholder="Phone Number" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">

            <input type="text" name="location" placeholder="Your Location" required value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">

            <textarea name="message" placeholder="Your Message..." required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>

            <button type="submit" name="send" id="sendBtn">✉️ Send Message</button>

            <!-- Contact Info Box with SILVER Hotel info -->
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p>Location: Musanze, Rwanda</p>
                <p>Phone: +250 786 511 490</p>
                <p>Email: goldenh123@gmail.com</p>
                <p>Mon-Sun: 8:00 AM - 10:00 PM</p>
            </div>
        </form>
    </div>

    <!-- SUCCESS MODAL POPUP -->
    <div id="successModal" class="success-modal">
        <div class="modal-content">
            <div class="check-icon">✓</div>
            <h3>Message Sent Successfully!</h3>
            <p>Thank you for contacting SILVER Hotel.</p>
            <p>We have received your message and will get back to you within 24 hours.</p>
            <div class="modal-buttons">
                <button class="btn-ok" onclick="closeModal()">OK, Got it!</button>
            </div>
        </div>
    </div>

    <!-- FOOTER with SILVER Hotel info -->
    <div class="footer">
        <p>Contact: +250 786 511 490 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | X</p>
        <p>© 2026 SILVER Hotel. All rights reserved.</p>
    </div>

    <script>
    // Background slideshow
    let bgSlides = document.querySelectorAll('.bg-slide');
    let currentBgSlide = 0;
    let totalBgSlides = bgSlides.length;
    
    function changeBgSlide() {
        if(bgSlides.length === 0) return;
        bgSlides[currentBgSlide].classList.remove('active');
        currentBgSlide++;
        if(currentBgSlide >= totalBgSlides) {
            currentBgSlide = 0;
        }
        bgSlides[currentBgSlide].classList.add('active');
    }
    
    // Change background every 4 seconds
    setInterval(changeBgSlide, 4000);
    
    <?php if($success_message): ?>
    // Show success modal when message is sent
    document.addEventListener('DOMContentLoaded', function() {
        let modal = document.getElementById('successModal');
        modal.classList.add('active');
        
        // Reset form
        document.getElementById('contactForm').reset();
    });
    <?php endif; ?>
    
    function closeModal() {
        let modal = document.getElementById('successModal');
        modal.classList.remove('active');
    }
    
    // Button loading effect
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        let btn = document.getElementById('sendBtn');
        btn.innerHTML = '⏳ Sending...';
        btn.style.opacity = '0.7';
        
        setTimeout(function() {
            if(!<?php echo $success_message ? 'true' : 'false'; ?>) {
                btn.innerHTML = 'Send Message';
                btn.style.opacity = '1';
            }
        }, 2000);
    });
    
    // Prevent form resubmission on page refresh
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
    
</body>
</html>