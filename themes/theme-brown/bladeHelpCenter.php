<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center</title>
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

        .search-container {
            padding: 20px;
            background-color: white;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px;
            padding-left: 40px;
            border: 1px solid #ddd;
            border-radius: 25px;
            background-color: var(--bg-color);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .tabs-container {
            background-color: white;
            padding: 0 20px;
        }

        .tabs {
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #eee;
        }

        .tab {
            padding: 15px 0;
            color: #666;
            cursor: pointer;
            position: relative;
            font-weight: 500;
        }

        .tab.active {
            color: var(--primary-brown);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary-brown);
        }

        .category-pills {
            display: flex;
            gap: 10px;
            padding: 20px;
            overflow-x: auto;
            background-color: white;
            scrollbar-width: none;
        }

        .category-pills::-webkit-scrollbar {
            display: none;
        }

        .pill {
            padding: 8px 20px;
            border-radius: 20px;
            background-color: var(--bg-color);
            color: #666;
            white-space: nowrap;
            cursor: pointer;
        }

        .pill.active {
            background-color: var(--primary-brown);
            color: white;
        }

        .faq-container, .contact-container {
            padding: 20px;
            display: none;
        }

        .faq-container.active, .contact-container.active {
            display: block;
        }

        .faq-item {
            background-color: white;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq-question {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .faq-answer {
            padding: 0 15px;
            color: #666;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .faq-answer.active {
            padding: 0 15px 15px;
            max-height: 200px;
        }

        .contact-option {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .contact-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-icon {
            width: 24px;
            color: var(--primary-brown);
        }

        @media (min-width: 768px) {
            .container {
                max-width: 768px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <button class="back-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h5 class="mb-0">Help Center</h5>
    </div>

    <div class="search-container">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search">
        </div>
    </div>

    <div class="tabs-container">
        <div class="tabs">
            <div class="tab active" data-tab="faq">FAQ</div>
            <div class="tab" data-tab="contact">Contact Us</div>
        </div>
    </div>

    <div class="faq-container active">
        <div class="category-pills">
            <div class="pill active">All</div>
            <div class="pill">Services</div>
            <div class="pill">General</div>
            <div class="pill">Account</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Can I track my order's delivery status?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer active">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Is there a return policy?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Can I save my favorite items for later?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Can I share products with my friends?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>How do I contact customer support?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What payment methods are accepted?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>How to add review?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer"></div>
        </div>
    </div>

    <div class="contact-container">
        <div class="contact-option">
            <div class="contact-left">
                <i class="fas fa-headset contact-icon"></i>
                <span>Customer Service</span>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="contact-option">
            <div class="contact-left">
                <i class="fab fa-whatsapp contact-icon"></i>
                <div>
                    <div>WhatsApp</div>
                    <div style="color: #666; font-size: 14px;">(480) 555-0103</div>
                </div>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="contact-option">
            <div class="contact-left">
                <i class="fas fa-globe contact-icon"></i>
                <span>Website</span>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="contact-option">
            <div class="contact-left">
                <i class="fab fa-facebook contact-icon"></i>
                <span>Facebook</span>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="contact-option">
            <div class="contact-left">
                <i class="fab fa-twitter contact-icon"></i>
                <span>Twitter</span>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="contact-option">
            <div class="contact-left">
                <i class="fab fa-instagram contact-icon"></i>
                <span>Instagram</span>
            </div>
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const tabName = this.dataset.tab;
                document.querySelectorAll('.faq-container, .contact-container').forEach(container => {
                    container.classList.remove('active');
                });
                document.querySelector(`.${tabName}-container`).classList.add('active');
            });
        });

        // Category pills
        document.querySelectorAll('.pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // FAQ accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                answer.classList.toggle('active');
                icon.style.transform = answer.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0)';
            });
        });
    </script>
</body>
</html>