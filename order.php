<?php
session_start();
include 'db.php';

// Check if user is logged in
if(!isset($_SESSION['user'])){
    header("location: loginorder.php");
    exit();
}

$success_message = "";
$error_message = "";
$order_placed = false;

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $menu = mysqli_real_escape_string($conn, $_POST['menu']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    
    // Using prepared statement for security
    $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, menu, address, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $menu, $address, $date);
    
    if($stmt->execute()){
        $success_message = "✓ Order placed successfully! Thank you for choosing Golden Horizon Hotel. Your order will be delivered on $date.";
        $order_placed = true;
    } else {
        $error_message = "✗ Failed to place order. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Your Meal - Golden Horizon Hotel</title>
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
        overflow-x: hidden;
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

    /* HEADER */
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
        letter-spacing: 2px;
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

    /* USER WELCOME */
    .user-welcome {
        position: fixed;
        top: 30px;
        right: 30px;
        z-index: 15;
        background: #CD853F;
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
        padding: 35px;
        width: 450px;
        border-radius: 15px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
        animation: fadeInUp 0.5s ease;
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

    input, select {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 15px;
        transition: all 0.3s;
    }

    input:focus, select:focus {
        outline: none;
        border: 1px solid #CD853F;
        box-shadow: 0 0 5px #CD853F;
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
        background: #CD853F;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px #CD853F;
    }

    /* MESSAGE STYLES */
    .success-message {
        background: #d4edda;
        color: #a1682f;
        border: 1px solid #d9c4af;
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

    /* ORDER SUMMARY (when order placed) */
    .order-summary {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px dashed #CD853F;
        font-size: 13px;
        color: #666;
        text-align: center;
    }

    /* SUCCESS POPUP MODAL */
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
        max-width: 450px;
        width: 90%;
        animation: scaleIn 0.3s ease;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
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

    .modal-content h3 {
        color: #CD853F;
        font-size: 28px;
        margin-bottom: 20px;
    }

    .modal-content .check-icon {
        font-size: 70px;
        color: #d5ab82;
        margin-bottom: 20px;
    }

    .modal-content p {
        color: #333;
        font-size: 16px;
        margin: 10px 0;
        line-height: 1.6;
    }

    .modal-content .order-details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: left;
    }

    .modal-content .order-details p {
        margin: 8px 0;
        font-size: 14px;
    }

    .modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;
    }

    .modal-buttons button {
        width: auto;
        padding: 12px 25px;
        margin: 0;
        font-size: 16px;
    }

    .btn-exit {
        background: #dc3545;
    }

    .btn-exit:hover {
        background: #c82333;
    }

    .btn-stay {
        background: #CD853F;
    }

    .btn-stay:hover {
        background: #CD853F;
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
             SILVER HOTEL
        </div>
    </div>

    <!-- USER WELCOME MESSAGE -->
    <div class="user-welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>! 
        <a href="loginorder.php">Logout</a>
    </div>

    <!-- FORM CONTAINER -->
    <div class="form-container">
        <form method="POST" id="orderForm">
            <h2>Order Your Meal</h2>
            
            <?php if($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <input type="text" name="name" placeholder="Full Name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

            <input type="email" name="email" placeholder="Email Address" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

            <input type="text" name="phone" placeholder="Phone Number" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">

            <select name="menu" required>
                <option value="">Select Your Menu</option>
                <option value="Fish" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Fish') ? 'selected' : ''; ?>>Fish</option>
                <option value="Chicken" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Chicken') ? 'selected' : ''; ?>>Chicken</option>
                <option value="Burger" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Burger') ? 'selected' : ''; ?>>Burger</option>
                <option value="Fresh Juice" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Fresh Juice') ? 'selected' : ''; ?>>Fresh Juice</option>
                <option value="Soda" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Soda') ? 'selected' : ''; ?>>Soda</option>
                <option value="Pizza" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Pizza') ? 'selected' : ''; ?>>Pizza</option>
                <option value="Beef Steak" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Beef Steak') ? 'selected' : ''; ?>>Beef Steak</option>
                <option value="French Fries" <?php echo (isset($_POST['menu']) && $_POST['menu']=='French Fries') ? 'selected' : ''; ?>>French Fries</option>
                <option value="Coffee" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Coffee') ? 'selected' : ''; ?>>Coffee</option>
                <option value="Ice Cream" <?php echo (isset($_POST['menu']) && $_POST['menu']=='Ice Cream') ? 'selected' : ''; ?>>Ice Cream</option>
            </select>

            <input type="text" name="address" placeholder="Delivery Address" required value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">

            <input type="date" name="date" required value="<?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : date('Y-m-d'); ?>">

            <button name="submit" id="submitBtn">Place Order Now</button>
            
            <div class="order-summary" style="margin-top:15px; border-top: none;">
                THANK YOU!! 
            </div>
        </form>
    </div>

    <!-- SUCCESS MODAL POPUP -->
    <div id="successModal" class="success-modal">
        <div class="modal-content">
            <div class="check-icon">✓</div>
            <h3>Order Successful!</h3>
            <p>Thank you for choosing Golden Horizon Hotel.</p>
            <div class="order-details">
                <p><strong>Menu:</strong> <?php echo isset($_POST['menu']) ? htmlspecialchars($_POST['menu']) : ''; ?></p>
                <p><strong>Delivery Date:</strong> <?php echo isset($_POST['date']) ? htmlspecialchars($_POST['date']) : ''; ?></p>
                <p><strong>Address:</strong> <?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></p>
                <p><strong>Contact:</strong> <?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?></p>
            </div>
            <p>Would you like to place another order or exit?</p>
            <div class="modal-buttons">
                <button class="btn-stay" onclick="stayOnPage()">Place Another Order</button>
                <button class="btn-exit" onclick="exitPage()">Exit</button>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Contact: +250 788354678 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>© 2026 Golden Horizon Hotel. All rights reserved.</p>
    </div>

    <script>
    // Background slideshow (same as login page)
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
    
    // Set minimum date to today
    let dateInput = document.querySelector('input[type="date"]');
    if(dateInput) {
        let today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
    }
    
    <?php if($order_placed && $success_message): ?>
    // Show success modal when order is placed
    document.addEventListener('DOMContentLoaded', function() {
        let modal = document.getElementById('successModal');
        modal.classList.add('active');
        
        // Clear form after successful order (optional)
        // You can reset form if needed
    });
    <?php endif; ?>
    
    function stayOnPage() {
        // Close modal and reset form for new order
        let modal = document.getElementById('successModal');
        modal.classList.remove('active');
        
        // Reset the form
        document.getElementById('orderForm').reset();
        
        // Set date to today again
        let dateInput = document.querySelector('input[type="date"]');
        if(dateInput) {
            let today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
        
        // Scroll to top smoothly
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function exitPage() {
        // Redirect to logout or home page
        window.location.href = 'loginorder.php';
    }
    
    // Close modal when clicking outside (optional)
    document.getElementById('successModal').addEventListener('click', function(e) {
        if(e.target === this) {
            // Do nothing - force user to choose button
            // This ensures user makes a choice
        }
    });
    
    // Prevent form resubmission on page refresh
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
    
</body>
</html>