<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
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

        .cart-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .cart-item {
            display: flex;
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 15px;
        }

        .product-details {
            flex-grow: 1;
        }

        .product-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .product-size {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .product-price {
            font-weight: bold;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 25px;
            height: 25px;
            border-radius: 8px;
            border: none;
            background-color: var(--primary-brown);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .quantity {
            font-weight: 500;
        }

        .delete-icon {
            color: #999;
            font-size: 14px;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .right-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
        }

        .promo-section {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            margin: 20px 0;
        }

        .promo-input {
            display: flex;
            gap: 10px;
        }

        .promo-input input {
            flex-grow: 1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 15px;
        }

        .apply-btn {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
        }

        .summary-section {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #666;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-weight: bold;
            color: black;
        }

        .checkout-btn {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 15px;
            width: 100%;
            margin-top: 20px;
            font-weight: 500;
        }

        @media (min-width: 768px) {
            .cart-container {
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
        <h5 class="mb-0">My Cart</h5>
    </div>

    <div class="cart-container">
        <div class="cart-item">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="product-image">
            <div class="product-details">
                <h6 class="product-title">Brown Jacket</h6>
                <div class="product-size">Size : XL</div>
                <div class="product-price">$83.97</div>
            </div>
            <div class="right-section">
                <i class="fas fa-trash delete-icon"></i>
                <div class="quantity-controls">
                    <button class="quantity-btn">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn">+</button>
                </div>
            </div>
        </div>

        <div class="cart-item">
            <img src="/api/placeholder/80/80" alt="Brown Suite" class="product-image">
            <div class="product-details">
                <h6 class="product-title">Brown Suite</h6>
                <div class="product-size">Size : XL</div>
                <div class="product-price">$120.00</div>
            </div>
            <div class="right-section">
                <i class="fas fa-trash delete-icon"></i>
                <div class="quantity-controls">
                    <button class="quantity-btn">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn">+</button>
                </div>
            </div>
        </div>

        <div class="cart-item">
            <img src="/api/placeholder/80/80" alt="Brown Jacket" class="product-image">
            <div class="product-details">
                <h6 class="product-title">Brown Jacket</h6>
                <div class="product-size">Size : XL</div>
                <div class="product-price">$83.97</div>
            </div>
            <div class="right-section">
                <i class="fas fa-trash delete-icon"></i>
                <div class="quantity-controls">
                    <button class="quantity-btn">-</button>
                    <span class="quantity">1</span>
                    <button class="quantity-btn">+</button>
                </div>
            </div>
        </div>

        <div class="promo-section">
            <div class="promo-input">
                <input type="text" placeholder="Promo Code">
                <button class="apply-btn">Apply</button>
            </div>
        </div>

        <div class="summary-section">
            <div class="summary-row">
                <span>Sub-Total</span>
                <span>$407.94</span>
            </div>
            <div class="summary-row">
                <span>Delivery Fee</span>
                <span>$25.00</span>
            </div>
            <div class="summary-row">
                <span>Discount</span>
                <span>-$35.00</span>
            </div>
            <div class="total-row">
                <span>Total Cost</span>
                <span>$397.94</span>
            </div>

            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </div>

    <script>
        // Quantity control functionality
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const quantitySpan = this.parentElement.querySelector('.quantity');
                let quantity = parseInt(quantitySpan.textContent);
                
                if (this.textContent === '+') {
                    quantity++;
                } else if (this.textContent === '-' && quantity > 1) {
                    quantity--;
                }
                
                quantitySpan.textContent = quantity;
            });
        });

        // Delete functionality
        document.querySelectorAll('.delete-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                this.closest('.cart-item').remove();
            });
        });
    </script>
</body>
</html>