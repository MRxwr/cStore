<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Store</title>
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
        }

        body {
            background-color: #FFFFFF;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-bottom: 80px;
        }

        .location-bar {
            padding: 15px;
            background-color: #FFFFFF;
        }

        .search-container {
            position: relative;
            margin: 15px;
        }

        .search-container input {
            background-color: #F5F5F5;
            border-radius: 25px;
            padding: 12px 20px;
            border: none;
            width: 100%;
        }

        .search-container .chat-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--primary-brown);
            color: white;
            padding: 8px;
            border-radius: 50%;
        }

        .banner {
            background-color: var(--light-beige);
            border-radius: 15px;
            margin: 15px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .category-section {
            padding: 15px;
        }

        .category-item {
            text-align: center;
            margin: 10px;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background-color: var(--light-beige);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .flash-sale {
            padding: 15px;
        }

        .timer {
            color: var(--primary-brown);
            font-weight: bold;
        }

        .product-card {
            background-color: #FFF;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card .favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: white;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
        }

        .product-info {
            padding: 15px;
        }

        .rating {
            color: #FFD700;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            padding: 15px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .nav-item {
            text-align: center;
            color: #666;
            cursor: pointer;
            transition: color 0.3s;
        }

        .nav-item.active {
            color: var(--primary-brown);
        }

        .sale-tabs {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding: 10px 15px;
            scrollbar-width: none;
        }

        .sale-tab {
            padding: 8px 20px;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
        }

        .sale-tab.active {
            background-color: var(--primary-brown);
            color: white;
        }

        /* Base mobile layout - 2 products per row */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 0 15px;
        }

        /* Tablet layout - 3 products per row */
        @media (min-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
        }

        /* Desktop layout - 4 products per row */
        @media (min-width: 992px) {
            .container {
                max-width: 1280px;
                margin: 0 auto;
                padding: 0 20px;
            }

            .product-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .category-section .row {
                justify-content: center;
            }

            .bottom-nav {
                max-width: 500px;
                left: 50%;
                transform: translateX(-50%);
                border-radius: 20px 20px 0 0;
            }
        }
    </style>
</head>
<body>
    <!-- Location Bar -->
    <div class="location-bar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-brown)"></i>
            <span>New York, USA</span>
            <i class="fas fa-chevron-down ms-2"></i>
        </div>
        <div class="profile">
            <img src="/api/placeholder/32/32" alt="Profile" class="rounded-circle">
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="text" placeholder="Search">
        <div class="chat-icon">
            <i class="fas fa-comments"></i>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner">
        <h4>New Collection</h4>
        <p>Discount 50% for<br>the first transaction</p>
        <button class="btn" style="background-color: var(--primary-brown); color: white;">Shop Now</button>
        <img src="/api/placeholder/200/200" alt="New Collection" style="position: absolute; right: 0; top: 0; height: 100%; object-fit: cover;">
    </div>

    <!-- Categories -->
    <div class="category-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Category</h6>
            <a href="#" style="color: var(--primary-brown); text-decoration: none;">See All</a>
        </div>
        <div class="row g-3">
            <div class="col-3">
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <small>T-Shirt</small>
                </div>
            </div>
            <div class="col-3">
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-socks"></i>
                    </div>
                    <small>Pant</small>
                </div>
            </div>
            <div class="col-3">
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <small>Dress</small>
                </div>
            </div>
            <div class="col-3">
                <div class="category-item">
                    <div class="category-icon">
                        <i class="fas fa-vest"></i>
                    </div>
                    <small>Jacket</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Sale -->
    <div class="flash-sale">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Flash Sale</h6>
            <div class="timer">02:12:56</div>
        </div>
        
        <div class="sale-tabs mb-3">
            <div class="sale-tab active">All</div>
            <div class="sale-tab">Newest</div>
            <div class="sale-tab">Popular</div>
            <div class="sale-tab">Man</div>
            <div class="sale-tab">Woman</div>
        </div>

        <div class="product-grid">
            <div class="product-card">
                <div class="favorite">
                    <i class="far fa-heart"></i>
                </div>
                <img src="/api/placeholder/400/300" alt="Brown Jacket">
                <div class="product-info">
                    <h6>Brown Jacket</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price">$83.97</span>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            4.9
                        </span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="favorite">
                    <i class="far fa-heart"></i>
                </div>
                <img src="/api/placeholder/400/300" alt="Brown Suite">
                <div class="product-info">
                    <h6>Brown Suite</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price">$120.00</span>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            5.0
                        </span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="favorite">
                    <i class="far fa-heart"></i>
                </div>
                <img src="/api/placeholder/400/300" alt="Brown Jacket">
                <div class="product-info">
                    <h6>Brown Jacket</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price">$83.97</span>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            4.9
                        </span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="favorite">
                    <i class="far fa-heart"></i>
                </div>
                <img src="/api/placeholder/400/300" alt="Yellow Shirt">
                <div class="product-info">
                    <h6>Yellow Shirt</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price">$120.00</span>
                        <span class="rating">
                            <i class="fas fa-star"></i>
                            5.0
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="row g-0">
            <div class="col nav-item active">
                <i class="fas fa-home"></i>
            </div>
            <div class="col nav-item">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="col nav-item">
                <i class="far fa-heart"></i>
            </div>
            <div class="col nav-item">
                <i class="far fa-comment"></i>
            </div>
            <div class="col nav-item">
                <i class="far fa-user"></i>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navigation functionality
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(nav => {
                    nav.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Sale tabs functionality
        document.querySelectorAll('.sale-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.sale-tab').forEach(t => {
                    t.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Favorite functionality
        document.querySelectorAll('.favorite').forEach(fav => {
            fav.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.classList.toggle('text-danger');
            });
        });
    </script>
</body>
</html>