<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Light Brown Jacket</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-brown: #8B4513;
            --light-beige: #F5F5DC;
            --dark-brown: #654321;
            --bg-color: #F5F5F5;
        }

        body {
            background-color: var(--bg-color);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .product-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--bg-color);
        }

        .back-button, .favorite-button {
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

        .main-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .thumbnail-container {
            padding: 15px;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .thumbnail-container::-webkit-scrollbar {
            display: none;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-right: 10px;
            object-fit: cover;
            cursor: pointer;
            display: inline-block;
        }

        .thumbnail.active {
            border: 2px solid var(--primary-brown);
        }

        .product-info {
            background-color: white;
            border-radius: 30px 30px 0 0;
            padding: 20px;
            margin-top: -30px;
        }

        .category {
            color: #666;
            font-size: 14px;
        }

        .rating {
            color: #FFD700;
        }

        .product-title {
            font-size: 24px;
            margin: 10px 0;
        }

        .description {
            color: #666;
            line-height: 1.6;
            margin: 15px 0;
        }

        .read-more {
            color: var(--primary-brown);
            text-decoration: none;
            font-weight: 500;
        }

        .size-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .size-option {
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .size-option.active {
            background-color: var(--primary-brown);
            color: white;
            border-color: var(--primary-brown);
        }

        .color-section {
            margin: 20px 0;
        }

        .color-options {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.active {
            border-color: var(--primary-brown);
        }

        .cart-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            margin-top: 20px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
        }

        .cart-button {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        @media (min-width: 768px) {
            .product-container {
                padding: 30px;
            }

            .main-image {
                height: 500px;
            }

            .product-content {
                max-width: 800px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="product-container">
        <div class="header">
            <button class="back-button">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2 class="mb-0">Product Details</h2>
            <button class="favorite-button">
                <i class="far fa-heart"></i>
            </button>
        </div>

        <div class="product-content">
            <img src="/api/placeholder/600/400" alt="Light Brown Jacket" class="main-image">
            
            <div class="thumbnail-container">
                <img src="/api/placeholder/80/80" alt="Thumbnail 1" class="thumbnail active">
                <img src="/api/placeholder/80/80" alt="Thumbnail 2" class="thumbnail">
                <img src="/api/placeholder/80/80" alt="Thumbnail 3" class="thumbnail">
                <img src="/api/placeholder/80/80" alt="Thumbnail 4" class="thumbnail">
                <img src="/api/placeholder/80/80" alt="Thumbnail 5" class="thumbnail">
                <img src="/api/placeholder/80/80" alt="Thumbnail 6" class="thumbnail">
            </div>

            <div class="product-info">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="category">Female's Style</span>
                    <span class="rating">
                        <i class="fas fa-star"></i>
                        4.5
                    </span>
                </div>

                <h1 class="product-title">Light Brown Jacket</h1>

                <div class="description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                    <a href="#" class="read-more">Read more</a>
                </div>

                <div class="size-section">
                    <h6>Select Size</h6>
                    <div class="size-grid">
                        <div class="size-option active">S</div>
                        <div class="size-option">M</div>
                        <div class="size-option">L</div>
                        <div class="size-option">XL</div>
                        <div class="size-option">XXL</div>
                        <div class="size-option">XXXL</div>
                    </div>
                </div>

                <div class="color-section">
                    <h6>Select Color : Brown</h6>
                    <div class="color-options">
                        <div class="color-option active" style="background-color: #D2B48C;"></div>
                        <div class="color-option" style="background-color: #8B4513;"></div>
                        <div class="color-option" style="background-color: #DEB887;"></div>
                        <div class="color-option" style="background-color: #A0522D;"></div>
                        <div class="color-option" style="background-color: #CD853F;"></div>
                        <div class="color-option" style="background-color: #000000;"></div>
                    </div>
                </div>

                <div class="cart-section">
                    <div class="price">$83.97</div>
                    <button class="cart-button">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Size selection
        document.querySelectorAll('.size-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Color selection
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Thumbnail selection
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.addEventListener('click', function() {
                document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                document.querySelector('.main-image').src = this.src;
            });
        });

        // Favorite button
        document.querySelector('.favorite-button').addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            icon.classList.toggle('text-danger');
        });
    </script>
</body>
</html>