<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user'])){
    header("location: login.php");
    exit();
}

// Check if columns exist, use correct column names
$orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
if(!$orders) {
    $orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");
    if(!$orders) {
        $orders = $conn->query("SELECT * FROM orders");
    }
}

$messages = $conn->query("SELECT * FROM contacts ORDER BY contact_id DESC");
if(!$messages) {
    $messages = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
    if(!$messages) {
        $messages = $conn->query("SELECT * FROM contacts");
    }
}

// Get counts
$total_orders = $orders->num_rows;
$total_messages = $messages->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SILVER Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            position: relative;
            min-height: 100vh;
            color: white;
            padding-bottom: 50px;
        }

        /* BACKGROUND IMAGE */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('heaven-restaurant-boutique.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 0.85;
            z-index: -2;
        }

        /* Dark overlay for better text visibility */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }

        /* HEADER with #CD853F */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background: #CD853F;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header h2 {
            font-size: 24px;
            color: white;
            letter-spacing: 1px;
        }

        .header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            background: #523a23de;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .header a:hover {
            background: #835420;
            transform: scale(1.05);
        }

        /* STATS CARDS */
        .stats-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding-top: 100px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(205,133,63,0.9);
            padding: 25px 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s;
            min-width: 200px;
            backdrop-filter: blur(5px);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            color: #FFFF00;
        }

        .stat-label {
            font-size: 18px;
            margin-top: 10px;
            color: white;
        }

        /* TITLE */
        .title {
            text-align: center;
            padding: 20px;
            font-size: 28px;
            color: #CD853F;
            border-bottom: 2px solid #CD853F;
            display: inline-block;
            width: auto;
            margin: 0 auto 20px auto;
            background: rgba(0,0,0,0.5);
            border-radius: 10px;
        }

        .section-title {
            text-align: center;
            margin: 40px 0 20px 0;
            font-size: 24px;
            color: #FFFF00;
        }

        /* TABLE */
        .table-container {
            width: 95%;
            margin: 20px auto;
            overflow-x: auto;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: black;
        }

        th {
            background: #CD853F;
            color: white;
            padding: 15px;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f0e6d2;
            transition: 0.3s;
        }

        .empty-row td {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }

        /* FOOTER */
        .footer {
            background: #523a23de;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 10px;
            }
            
            .header h2 {
                font-size: 18px;
            }
            
            .stats-container {
                padding-top: 120px;
                gap: 15px;
            }
            
            .stat-card {
                padding: 15px 25px;
                min-width: 140px;
            }
            
            .stat-number {
                font-size: 32px;
            }
            
            .stat-label {
                font-size: 14px;
            }
            
            .title {
                font-size: 22px;
            }
            
            th, td {
                padding: 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h2>SILVER Hotel - Admin Dashboard</h2>
        <a href="home.php">Logout</a>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_orders; ?></div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_messages; ?></div>
            <div class="stat-label">Messages Received</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo date('d/m/Y'); ?></div>
            <div class="stat-label">Today's Date</div>
        </div>
    </div>

    <!-- ORDERS SECTION -->
    <div style="text-align: center;">
        <div class="title">CUSTOMER ORDERS</div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Menu</th>
                    <th>Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if($total_orders > 0): ?>
                    <?php $counter = 1; while($row = $orders->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="7">No orders found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- CONTACT SECTION -->
    <div style="text-align: center;">
        <div class="title">CUSTOMER MESSAGES</div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php if($total_messages > 0): ?>
                    <?php $counter = 1; while($msg = $messages->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><?php echo htmlspecialchars($msg['email']); ?></td>
                            <td><?php echo htmlspecialchars($msg['phone']); ?></td>
                            <td><?php echo htmlspecialchars($msg['location']); ?></td>
                            <td style="text-align: left; max-width: 300px;"><?php echo htmlspecialchars($msg['message']); ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr class="empty-row">
                        <td colspan="6">No messages found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Contact: +250 788354678 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>© 2026 Golden Horizon Hotel. All rights reserved.</p>
    </div>

</body>
</html>