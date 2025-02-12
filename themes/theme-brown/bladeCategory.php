<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
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

        .category-scroll {
            padding: 0 20px;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
            -ms-overflow-style: none;
            margin-bottom: 20px;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            display: inline-block;
            padding: 8px 20px;
            margin-right: 10px;
            border-radius: 20px;
            background-color: white;
            color: #333;
            cursor: pointer;
        }

        .category-pill.active {
            background-color: var(--primary-brown);
            color: white;
        }

        .product-grid {
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
        }

        .favorite-button {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .product-info {
            padding: 12px;
        }

        .product-title {
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }

        .product-price {
            font-weight: bold;
            margin-top: 5px;
        }

        .rating {
            color: #FFD700;
            font-size: 12px;
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
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 1280px;
                margin: 0 auto;
            }

            .bottom-nav {
                max-width: 500px;
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">My Wishlist</h5>
    </div>

    <div class="category-scroll">
        <span class="category-pill">All</span>
        <span class="category-pill active">Jacket</span>
        <span class="category-pill">Shirt</span>
        <span class="category-pill">Pant</span>
        <span class="category-pill">T-Shirt</span>
    </div>

    <div class="product-grid">
        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Brown Jacket" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Brown Jacket</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$83.97</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        4.9
                    </span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Brown Suite" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Brown Suite</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$120.00</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        5.0
                    </span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Brown Jacket" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Brown Jacket</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$83.97</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        4.9
                    </span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Yellow Shirt" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Yellow Shirt</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$120.00</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        5.0
                    </span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Brown Jacket" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Brown Jacket</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$83.97</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        4.9
                    </span>
                </div>
            </div>
        </div>

        <div class="product-card">
            <img src="/api/placeholder/300/300" alt="Brown Suite" class="product-image">
            <button class="favorite-button">
                <i class="fas fa-heart" style="color: #ff0000;"></i>
            </button>
            <div class="product-info">
                <h3 class="product-title">Brown Suite</h3>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="product-price">$120.00</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        5.0
                    </span>
                </div>
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
        <a href="#" class="nav-item active">
            <i class="fas fa-heart"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-comment"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user"></i>
        </a>
    </div>

    <script>
        // Category selection
        document.querySelectorAll('.category-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>