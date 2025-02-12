<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
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
            line-height: 1.6;
        }

        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: white;
            position: sticky;
            top: 0;
            z-index: 100;
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

        .policy-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px;
        }

        .policy-section {
            margin-bottom: 30px;
        }

        .section-title {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .section-content {
            color: #666;
            font-size: 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .policy-container {
                padding: 30px;
                max-width: 800px;
            }

            .section-content {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">Privacy Policy</h5>
    </div>

    <div class="policy-container">
        <div class="policy-section">
            <h2 class="section-title">Cancelation Policy</h2>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.
            </div>
        </div>

        <div class="policy-section">
            <h2 class="section-title">Terms & Condition</h2>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
            <div class="section-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
        </div>
    </div>

    <script>
        // Back button functionality
        document.querySelector('.back-button').addEventListener('click', function() {
            window.history.back();
        });
    </script>
</body>
</html>