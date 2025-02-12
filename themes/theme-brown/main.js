// Navigation Configuration
const APP_ROUTES = {
    // Main Navigation
    'home': 'index.html',
    'cart': 'cart.html',
    'wishlist': 'wishlist.html',
    'profile': 'profile.html',
    'chat': 'chat.html',

    // Profile Section
    'profile-details': 'profile-details.html',
    'payment-methods': 'payment-methods.html',
    'orders': 'orders.html',
    'settings': 'settings.html',
    'help-center': 'help-center.html',
    'privacy-policy': 'privacy-policy.html',
    'shipping-address': 'shipping-address.html',

    // Product Related
    'product-details': 'product-details.html',
    'checkout': 'checkout.html',
    'track-order': 'track-order.html',
};

// Loading State Management
class LoadingManager {
    constructor() {
        this.loadingOverlay = document.getElementById('loadingSpinner');
    }

    show() {
        this.loadingOverlay.classList.add('active');
    }

    hide() {
        this.loadingOverlay.classList.remove('active');
    }

    async withLoading(callback, delay = 800) {
        this.show();
        await new Promise(resolve => setTimeout(resolve, delay));
        try {
            await callback();
        } finally {
            this.hide();
        }
    }
}

// Navigation Manager
class NavigationManager {
    constructor() {
        this.loading = new LoadingManager();
    }

    async navigateTo(route) {
        if (APP_ROUTES[route]) {
            await this.loading.withLoading(() => {
                window.location.href = APP_ROUTES[route];
            });
        }
    }

    async goBack() {
        await this.loading.withLoading(() => {
            window.history.back();
        });
    }

    setupEventListeners() {
        // Back button handlers
        document.querySelectorAll('.back-button').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.goBack();
            });
        });

        // Bottom navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const route = item.dataset.route;
                if (route) this.navigateTo(route);
            });
        });

        // Menu items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', (e) => {
                const route = item.dataset.route;
                if (route) {
                    e.preventDefault();
                    this.navigateTo(route);
                }
            });
        });

        // Generic navigation elements
        document.querySelectorAll('[data-navigate]').forEach(element => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                const route = element.dataset.navigate;
                if (route) this.navigateTo(route);
            });
        });
    }
}

// Cart Management
class CartManager {
    constructor() {
        this.cart = JSON.parse(localStorage.getItem('cart') || '[]');
    }

    addToCart(product) {
        this.cart.push(product);
        this.saveCart();
        this.updateCartUI();
    }

    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartUI();
    }

    updateQuantity(productId, quantity) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
            item.quantity = quantity;
            this.saveCart();
            this.updateCartUI();
        }
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
    }

    updateCartUI() {
        // Update cart count badge
        const cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            cartBadge.textContent = this.cart.length;
        }

        // Update cart total if on cart page
        const cartTotal = document.querySelector('.cart-total');
        if (cartTotal) {
            const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `$${total.toFixed(2)}`;
        }
    }
}

// Wishlist Management
class WishlistManager {
    constructor() {
        this.wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    }

    toggleWishlist(productId) {
        const index = this.wishlist.indexOf(productId);
        if (index > -1) {
            this.wishlist.splice(index, 1);
        } else {
            this.wishlist.push(productId);
        }
        this.saveWishlist();
        this.updateWishlistUI();
    }

    saveWishlist() {
        localStorage.setItem('wishlist', JSON.stringify(this.wishlist));
    }

    updateWishlistUI() {
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            const productId = btn.dataset.productId;
            if (this.wishlist.includes(productId)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
}

// Initialize App
document.addEventListener('DOMContentLoaded', () => {
    const navigation = new NavigationManager();
    const cart = new CartManager();
    const wishlist = new WishlistManager();

    navigation.setupEventListeners();
    cart.updateCartUI();
    wishlist.updateWishlistUI();

    // Initialize specific page features
    initializePageSpecificFeatures();
});

// Page Specific Initializations
function initializePageSpecificFeatures() {
    // Product quantity controls
    document.querySelectorAll('.quantity-control').forEach(control => {
        control.addEventListener('click', (e) => {
            const input = control.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            if (control.classList.contains('increment')) {
                input.value = currentValue + 1;
            } else if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });

    // Tab switching
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabGroup = this.closest('.tabs');
            tabGroup.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const targetId = this.dataset.target;
            if (targetId) {
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.style.display = 'none';
                });
                document.getElementById(targetId).style.display = 'block';
            }
        });
    });
}