<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
            padding-bottom: 80px;
        }

        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .checkout-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .info-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            position: relative;
        }

        .address-type {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .address-details {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .change-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--primary-brown);
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
        }

        .shipping-type {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .estimated-date {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
            margin-left: 34px;
        }

        .order-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .order-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-size {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .item-price {
            font-weight: bold;
        }

        .continue-btn {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px;
            font-weight: 500;
            max-width: 1280px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .checkout-container {
                padding: 0 40px;
            }

            .continue-btn {
                max-width: 400px;
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">Checkout</h5>
    </div>

    <div class="checkout-container">
        <div class="section-title">Shipping Address</div>
        <div class="info-card">
            <div class="address-type">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-brown)"></i>
                <span>Home</span>
            </div>
            <div class="address-details">
                1901 Thornridge Cir. Shiloh, Hawaii 81053
            </div>
            <a href="#" class="change-link">CHANGE</a>
        </div>

        <div class="section-title">Choose Shipping Type</div>
        <div class="info-card">
            <div class="shipping-type">
                <i class="fas fa-box" style="color: var(--primary-brown)"></i>
                <span>Economy</span>
            </div>
            <div class="estimated-date">
                Estimated Arrival: 25 August 2023
            </div>
            <a href="#" class="change-link">CHANGE</a>
        </div>

        <div class="section-title">Order List</div>
        <div class="info-card">
            <div class="order-item">
                <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
                <div class="item-details">
                    <div class="item-name">Brown Jacket</div>
                    <div class="item-size">Size: XL</div>
                    <div class="item-price">$83.97</div>
                </div>
            </div>

            <div class="order-item">
                <img src="/api/placeholder/80/80" alt="Brown Suite" class="order-image">
                <div class="item-details">
                    <div class="item-name">Brown Suite</div>
                    <div class="item-size">Size: XL</div>
                    <div class="item-price">$120.00</div>
                </div>
            </div>

            <div class="order-item">
                <img src="/api/placeholder/80/80" alt="Brown Jacket" class="order-image">
                <div class="item-details">
                    <div class="item-name">Brown Jacket</div>
                    <div class="item-size">Size: XL</div>
                    <div class="item-price">$83.97</div>
                </div>
            </div>
        </div>
    </div>

    <button class="continue-btn">Continue to Payment</button>
</body>
</html>