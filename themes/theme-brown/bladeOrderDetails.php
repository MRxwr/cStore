<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
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

        .track-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .order-summary {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-details {
            flex-grow: 1;
        }

        .product-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .product-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .product-price {
            font-weight: bold;
        }

        .detail-section {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .detail-label {
            color: #666;
        }

        .detail-value {
            font-weight: 500;
        }

        .timeline-container {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            position: relative;
            padding-bottom: 30px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #ddd;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-dot.completed {
            background-color: var(--primary-brown);
            border-color: var(--primary-brown);
            color: white;
        }

        .timeline-line {
            position: absolute;
            left: 11px;
            top: 24px;
            bottom: 0;
            width: 2px;
            background-color: #ddd;
        }

        .timeline-content {
            flex-grow: 1;
        }

        .timeline-status {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .timeline-date {
            color: #666;
            font-size: 14px;
        }

        .timeline-icon {
            width: 24px;
            height: 24px;
            color: #666;
        }

        @media (min-width: 768px) {
            .track-container {
                padding: 0 40px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">Track Order</h5>
    </div>

    <div class="track-container">
        <div class="order-summary">
            <img src="/api/placeholder/80/80" alt="Brown Suite" class="product-image">
            <div class="product-details">
                <div class="product-title">Brown Suite</div>
                <div class="product-info">Size: XL | Qty: 10pcs</div>
                <div class="product-price">$120</div>
            </div>
        </div>

        <div class="detail-section">
            <div class="section-title">Order Details</div>
            <div class="detail-row">
                <span class="detail-label">Expected Delivery Date</span>
                <span class="detail-value">03 Sep 2023</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tracking ID</span>
                <span class="detail-value">TRK452126542</span>
            </div>
        </div>

        <div class="timeline-container">
            <div class="section-title">Order Status</div>
            
            <div class="timeline-item">
                <div class="timeline-dot completed">
                    <i class="fas fa-check" style="font-size: 12px;"></i>
                </div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <div class="timeline-status">Order Placed</div>
                    <div class="timeline-date">23 Aug 2023, 04:25 PM</div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot completed">
                    <i class="fas fa-check" style="font-size: 12px;"></i>
                </div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <div class="timeline-status">In Progress</div>
                    <div class="timeline-date">23 Aug 2023, 03:54 PM</div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-cog"></i>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot">
                </div>
                <div class="timeline-line"></div>
                <div class="timeline-content">
                    <div class="timeline-status">Shipped</div>
                    <div class="timeline-date">Expected 02 Sep 2023</div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-truck"></i>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-dot">
                </div>
                <div class="timeline-content">
                    <div class="timeline-status">Delivered</div>
                    <div class="timeline-date">23 Aug 2023</div>
                </div>
                <div class="timeline-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>
</body>
</html>