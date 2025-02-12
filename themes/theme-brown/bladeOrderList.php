<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #8B4513;
            --light-beige: #F5F5DC;
            --bg-color: #F5F5F5;
        }

        body {
            background-color: var(--bg-color);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: white;
        }

        .back-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }

        .tabs-container {
            background-color: white;
            padding: 0 20px;
        }

        .tabs {
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #eee;
        }

        .tab {
            padding: 15px 0;
            color: #666;
            cursor: pointer;
            position: relative;
            font-weight: 500;
        }

        .tab.active {
            color: var(--primary-brown);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary-brown);
        }

        .orders-container {
            padding: 20px;
            max-width: 1280px;
            margin: 0 auto;
        }

        .order-card {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
        }

        .order-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        .order-details {
            flex-grow: 1;
        }

        .order-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .order-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .order-price {
            font-weight: bold;
        }

        .track-btn {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            font-size: 14px;
            align-self: flex-end;
        }

        @media (min-width: 768px) {
            .orders-container {
                padding: 20px 40px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">My Orders</h5>
    </div>

    <div class="tabs-container">
        <div class="tabs">
            <div class="tab active">Active</div>
            <div class="tab">Completed</div>
            <div class="tab">Cancelled</div>
        </div>
    </div>

    <div class="orders-container">
        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Jacket</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$83.97</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>

        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Suite" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Suite</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$120.00</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>

        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Suite" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Suite</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$120.00</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>

        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Jacket</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$83.97</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>

        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Jacket</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$83.97</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>

        <div class="order-card">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
            <div class="order-details">
                <div class="order-title">Brown Jacket</div>
                <div class="order-info">Size: XL | Qty: 10pcs</div>
                <div class="order-price">$83.97</div>
            </div>
            <button class="track-btn">Track Order</button>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>