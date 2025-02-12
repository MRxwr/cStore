<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

        .profile-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .profile-header {
            background-color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
        }

        .avatar-container {
            position: relative;
            margin-bottom: 15px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .edit-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 30px;
            height: 30px;
            background-color: var(--primary-brown);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 3px solid white;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 600;
        }

        .menu-container {
            background-color: white;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-icon {
            width: 24px;
            color: #666;
            margin-right: 15px;
        }

        .menu-text {
            flex-grow: 1;
            color: #333;
        }

        .menu-arrow {
            color: #666;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #1E1E1E;
            padding: 15px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-around;
            z-index: 1000;
        }

        .nav-item {
            color: #666;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            font-size: 20px;
        }

        .nav-item.active {
            color: white;
        }

        @media (min-width: 768px) {
            .menu-container {
                border-radius: 15px;
                margin: 0 20px;
            }

            .bottom-nav {
                max-width: 500px;
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
        <h5 class="mb-0">Profile</h5>
    </div>

    <div class="profile-container">
        <div class="profile-header">
            <div class="avatar-container">
                <img src="/api/placeholder/100/100" alt="Profile" class="avatar">
                <div class="edit-badge">
                    <i class="fas fa-pencil-alt" style="font-size: 12px;"></i>
                </div>
            </div>
            <div class="profile-name">Esther Howard</div>
        </div>

        <div class="menu-container">
            <div class="menu-item">
                <i class="fas fa-user menu-icon"></i>
                <span class="menu-text">Your profile</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-credit-card menu-icon"></i>
                <span class="menu-text">Payment Methods</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-box menu-icon"></i>
                <span class="menu-text">My Orders</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-text">Settings</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-question-circle menu-icon"></i>
                <span class="menu-text">Help Center</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-shield-alt menu-icon"></i>
                <span class="menu-text">Privacy Policy</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-user-plus menu-icon"></i>
                <span class="menu-text">Invites Friends</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
            <div class="menu-item">
                <i class="fas fa-sign-out-alt menu-icon"></i>
                <span class="menu-text">Log out</span>
                <i class="fas fa-chevron-right menu-arrow"></i>
            </div>
        </div>
    </div>

    <div class="bottom-nav">
        <a href="#" class="nav-item">
            <i class="fas fa-home"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-shopping-bag"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-heart"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-comment"></i>
        </a>
        <a href="#" class="nav-item active">
            <i class="fas fa-user"></i>
        </a>
    </div>

    <script>
        // Menu item click effect
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                // Add click effect or navigation here
            });
        });
    </script>
</body>
</html>