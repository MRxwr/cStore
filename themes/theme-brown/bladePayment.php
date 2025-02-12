<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
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
            background-color: var(--bg-color);
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

        .payment-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .payment-option {
            background-color: white;
            border-radius: 15px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .payment-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
        }

        .payment-icon img {
            width: 100%;
            height: auto;
        }

        .payment-name {
            flex-grow: 1;
            font-size: 15px;
            color: #333;
        }

        .radio-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radio-custom.active {
            border-color: var(--primary-brown);
        }

        .radio-custom.active::after {
            content: '';
            width: 12px;
            height: 12px;
            background-color: var(--primary-brown);
            border-radius: 50%;
        }

        .add-card {
            color: #333;
            text-decoration: none;
        }

        .add-card i {
            color: #666;
        }

        .confirm-btn {
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
            .payment-container {
                padding: 0 40px;
            }

            .confirm-btn {
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
        <h5 class="mb-0">Payment Methods</h5>
    </div>

    <div class="payment-container">
        <div class="section-title">Credit & Debit Card</div>
        <div class="payment-option">
            <div class="payment-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="payment-name">Add Card</div>
            <i class="fas fa-chevron-right text-muted"></i>
        </div>

        <div class="section-title mt-4">More Payment Options</div>
        
        <div class="payment-option">
            <div class="payment-icon">
                <img src="/api/placeholder/24/24" alt="PayPal">
            </div>
            <div class="payment-name">Paypal</div>
            <div class="radio-custom"></div>
        </div>

        <div class="payment-option">
            <div class="payment-icon">
                <img src="/api/placeholder/24/24" alt="Apple Pay">
            </div>
            <div class="payment-name">Apple Pay</div>
            <div class="radio-custom"></div>
        </div>

        <div class="payment-option">
            <div class="payment-icon">
                <img src="/api/placeholder/24/24" alt="Google Pay">
            </div>
            <div class="payment-name">Google Pay</div>
            <div class="radio-custom"></div>
        </div>
    </div>

    <button class="confirm-btn">Confirm Payment</button>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            const radio = option.querySelector('.radio-custom');
            if (radio) {  // Only add click event if it has a radio button
                option.addEventListener('click', function() {
                    document.querySelectorAll('.radio-custom').forEach(r => {
                        r.classList.remove('active');
                    });
                    radio.classList.add('active');
                });
            }
        });
    </script>
</body>
</html>