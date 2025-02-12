<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Address</title>
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

        .address-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .address-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            cursor: pointer;
        }

        .address-type {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .address-details {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .radio-custom {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 3px;
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

        .add-address-btn {
            border: 2px dashed #ccc;
            background-color: transparent;
            border-radius: 15px;
            padding: 15px;
            width: 100%;
            text-align: center;
            color: #666;
            margin-top: 20px;
        }

        .add-address-btn i {
            margin-right: 8px;
        }

        .apply-btn {
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
            .address-container {
                padding: 0 40px;
            }

            .apply-btn {
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
        <h5 class="mb-0">Shipping Address</h5>
    </div>

    <div class="address-container">
        <div class="address-card">
            <div class="location-icon">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-brown)"></i>
            </div>
            <div class="flex-grow-1">
                <div class="address-type">Home</div>
                <div class="address-details">1901 Thornridge Cir. Shiloh, Hawaii 91053</div>
            </div>
            <div class="radio-custom active"></div>
        </div>

        <div class="address-card">
            <div class="location-icon">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-brown)"></i>
            </div>
            <div class="flex-grow-1">
                <div class="address-type">Office</div>
                <div class="address-details">4517 Washington Ave. Manchester, Kentucky 39495</div>
            </div>
            <div class="radio-custom"></div>
        </div>

        <div class="address-card">
            <div class="location-icon">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-brown)"></i>
            </div>
            <div class="flex-grow-1">
                <div class="address-type">Parent's House</div>
                <div class="address-details">8502 Preston Rd. Inglewood, Maine 98380</div>
            </div>
            <div class="radio-custom"></div>
        </div>

        <div class="address-card">
            <div class="location-icon">
                <i class="fas fa-map-marker-alt" style="color: var(--primary-brown)"></i>
            </div>
            <div class="flex-grow-1">
                <div class="address-type">Friend's House</div>
                <div class="address-details">2464 Royal Ln. Mesa, New Jersey 45463</div>
            </div>
            <div class="radio-custom"></div>
        </div>

        <button class="add-address-btn">
            <i class="fas fa-plus"></i>Add New Shipping Address
        </button>
    </div>

    <button class="apply-btn">Apply</button>

    <script>
        // Address selection functionality
        document.querySelectorAll('.address-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.radio-custom').forEach(radio => {
                    radio.classList.remove('active');
                });
                this.querySelector('.radio-custom').classList.add('active');
            });
        });
    </script>
</body>
</html>