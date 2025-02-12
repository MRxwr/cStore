<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .success-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: -60px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background-color: var(--primary-brown);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            animation: scaleIn 0.5s ease-out;
        }

        .success-icon i {
            color: white;
            font-size: 40px;
            animation: checkmark 0.3s ease-in-out 0.5s both;
        }

        .success-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            animation: fadeIn 0.5s ease-out 0.3s both;
        }

        .success-message {
            color: #666;
            margin-bottom: 40px;
            animation: fadeIn 0.5s ease-out 0.4s both;
        }

        .action-buttons {
            width: 100%;
            max-width: 300px;
            animation: fadeIn 0.5s ease-out 0.5s both;
        }

        .view-order-btn {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px;
            width: 100%;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .view-receipt {
            color: var(--primary-brown);
            text-decoration: none;
            text-align: center;
            display: block;
            font-weight: 500;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            60% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">Payment</h5>
    </div>

    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        <h2 class="success-title">Payment Successful!</h2>
        <p class="success-message">Thank you for your purchase.</p>
        
        <div class="action-buttons">
            <button class="view-order-btn">View Order</button>
            <a href="#" class="view-receipt">View E-Receipt</a>
        </div>
    </div>

</body>
</html>