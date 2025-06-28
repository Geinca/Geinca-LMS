<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Online Courses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header with Sticky Navigation -->
    <header id="header">
        <nav class="navbar">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>LearnHub</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="#">Categories</a></li>
                <li><a href="#">My Learning</a></li>
                <li><a href="#">Teach</a></li>
                <li><a href="#">Business</a></li>
                  <li><a href="#" class="login-btn">Login</a></li>
    <li><a href="#" class="signup-btn">Sign Up</a></li>
            </ul>
            
            <div class="nav-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for courses">
                </div>
                
                <div class="cart-icon" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                
                <div class="user-avatar">JS</div>
                
                <button class="mobile-nav-btn" id="mobileNavBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </header>
    
    <!-- Mobile Navigation -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
    
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>LearnHub</span>
            </a>
            <button id="closeMobileNav">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <ul class="mobile-nav-links">
             <li><a href="#">Home</a></li>
    <li><a href="#">Categories</a></li>
    <li><a href="#">My Learning</a></li>
    <li><a href="#">Teach</a></li>
    <li><a href="#">Business</a></li>
    <li><a href="#" class="login-btn">Login</a></li>
    <li><a href="#" class="signup-btn">Sign Up</a></li>
        </ul>
    </div>
    

    <div id="hero"></div>
<div id="stats"></div>
    
    <!-- Main Content -->
    <div class="container">
        <h1>Class Courses</h1>
        
        <!-- Course Tabs -->
        <div class="tabs">
            <div class="tab active" data-tab="class8">Class 8</div>
            <div class="tab" data-tab="class9">Class 9</div>
            <div class="tab" data-tab="class10">Class 10</div>
        </div>
        
        <!-- Class 8 Courses -->
        <div class="tab-content active" id="class8">
            <div class="course-grid">
                <!-- Course 1 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Mathematics" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Mathematics Mastery - Class 8</h3>
                        <p class="course-instructor">By Prof. Sharma</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="1" data-title="Mathematics Mastery - Class 8" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 2 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Science" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Science Fundamentals - Class 8</h3>
                        <p class="course-instructor">By Dr. Patel</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="2" data-title="Science Fundamentals - Class 8" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 3 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="English" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">English Grammar - Class 8</h3>
                        <p class="course-instructor">By Ms. Gupta</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="3" data-title="English Grammar - Class 8" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 4 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="History" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">History & Civics - Class 8</h3>
                        <p class="course-instructor">By Mr. Singh</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="4" data-title="History & Civics - Class 8" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Class 9 Courses -->
        <div class="tab-content" id="class9">
            <div class="course-grid">
                <!-- Course 1 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Mathematics" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Advanced Mathematics - Class 9</h3>
                        <p class="course-instructor">By Prof. Verma</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="5" data-title="Advanced Mathematics - Class 9" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 2 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Science" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Physics Concepts - Class 9</h3>
                        <p class="course-instructor">By Dr. Reddy</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="6" data-title="Physics Concepts - Class 9" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 3 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="English" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">English Literature - Class 9</h3>
                        <p class="course-instructor">By Ms. Kapoor</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="7" data-title="English Literature - Class 9" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 4 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Geography" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Geography Essentials - Class 9</h3>
                        <p class="course-instructor">By Mr. Khan</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="8" data-title="Geography Essentials - Class 9" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Class 10 Courses -->
        <div class="tab-content" id="class10">
            <div class="course-grid">
                <!-- Course 1 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Mathematics" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Mathematics for Board Exams - Class 10</h3>
                        <p class="course-instructor">By Prof. Joshi</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="9" data-title="Mathematics for Board Exams - Class 10" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 2 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Science" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Chemistry Fundamentals - Class 10</h3>
                        <p class="course-instructor">By Dr. Iyer</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="10" data-title="Chemistry Fundamentals - Class 10" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 3 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="English" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">English Writing Skills - Class 10</h3>
                        <p class="course-instructor">By Ms. Desai</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="11" data-title="English Writing Skills - Class 10" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
                
                <!-- Course 4 -->
                <div class="course-card">
                    <img src="https://i.ibb.co/DfsDp9kX/971.jpg" alt="Economics" class="course-img">
                    <div class="course-info">
                        <h3 class="course-title">Social Science - Class 10</h3>
                        <p class="course-instructor">By Mr. Choudhary</p>
                        <p class="course-price">₹1/day</p>
                        <button class="add-to-cart" data-id="12" data-title="Social Science - Class 10" data-price="1" data-img="https://i.ibb.co/DfsDp9kX/971.jpg">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Shopping Cart -->
    <div class="cart-overlay" id="cartOverlay"></div>
    
    <div class="cart-modal" id="cartModal">
        <div class="cart-header">
            <h2 class="cart-title">Your Cart</h2>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <p>Your cart is empty</p>
            </div>
        </div>
        
        <div class="cart-total">
            <span>Total:</span>
            <span id="cartTotal">₹0</span>
        </div>
        
        <button class="checkout-btn">Checkout</button>
    </div>
    
    <div id="test"></div>
     <div id="footer"></div>
    <script>
        // Sticky Header
        const header = document.getElementById('header');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Mobile Navigation
        const mobileNavBtn = document.getElementById('mobileNavBtn');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavOverlay = document.getElementById('mobileNavOverlay');
        const closeMobileNav = document.getElementById('closeMobileNav');
        
        mobileNavBtn.addEventListener('click', () => {
            mobileNav.classList.add('active');
            mobileNavOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        closeMobileNav.addEventListener('click', () => {
            mobileNav.classList.remove('active');
            mobileNavOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        mobileNavOverlay.addEventListener('click', () => {
            mobileNav.classList.remove('active');
            mobileNavOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Tab Navigation
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Shopping Cart
        const cartIcon = document.getElementById('cartIcon');
        const cartModal = document.getElementById('cartModal');
        const cartOverlay = document.getElementById('cartOverlay');
        const closeCart = document.getElementById('closeCart');
        const cartCount = document.getElementById('cartCount');
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        
        let cart = [];
        
        // Open/Close Cart
        cartIcon.addEventListener('click', () => {
            cartModal.classList.add('active');
            cartOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        closeCart.addEventListener('click', () => {
            cartModal.classList.remove('active');
            cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        cartOverlay.addEventListener('click', () => {
            cartModal.classList.remove('active');
            cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Add to Cart
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const price = parseFloat(button.getAttribute('data-price'));
                const img = button.getAttribute('data-img');
                
                // Check if item already in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id,
                        title,
                        price,
                        img,
                        quantity: 1,
                        days: 1
                    });
                }
                
                updateCart();
                
                // Visual feedback
                button.textContent = 'Added to Cart';
                button.style.backgroundColor = '#4CAF50';
                
                setTimeout(() => {
                    button.textContent = 'Add to Cart';
                    button.style.backgroundColor = '';
                }, 1500);
            });
        });
        
        // Update Cart
        function updateCart() {
            // Update cart count
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            cartCount.textContent = totalItems;
            
            // Update cart items
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p>Your cart is empty</p>
                    </div>
                `;
                cartTotal.textContent = '₹0';
            } else {
                cartItems.innerHTML = '';
                
                let total = 0;
                
                cart.forEach(item => {
                    const itemTotal = item.price * item.days * item.quantity;
                    total += itemTotal;
                    
                    const cartItemElement = document.createElement('div');
                    cartItemElement.className = 'cart-item';
                    cartItemElement.innerHTML = `
                        <img src="${item.img}" alt="${item.title}" class="cart-item-img">
                        <div class="cart-item-details">
                            <h4 class="cart-item-title">${item.title}</h4>
                            <p class="cart-item-price">₹${item.price}/day × ${item.days} days</p>
                            <div class="days-selector">
                                <button class="decrease-days" data-id="${item.id}">-</button>
                                <input type="number" value="${item.days}" min="1" class="days-input" data-id="${item.id}">
                                <button class="increase-days" data-id="${item.id}">+</button>
                            </div>
                            <button class="remove-item" data-id="${item.id}">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    `;
                    
                    cartItems.appendChild(cartItemElement);
                });
                
                cartTotal.textContent = `₹${total.toFixed(2)}`;
                
                // Add event listeners to new elements
                document.querySelectorAll('.decrease-days').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const id = e.target.getAttribute('data-id');
                        const item = cart.find(item => item.id === id);
                        if (item.days > 1) {
                            item.days -= 1;
                            updateCart();
                        }
                    });
                });
                
                document.querySelectorAll('.increase-days').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const id = e.target.getAttribute('data-id');
                        const item = cart.find(item => item.id === id);
                        item.days += 1;
                        updateCart();
                    });
                });
                
                document.querySelectorAll('.days-input').forEach(input => {
                    input.addEventListener('change', (e) => {
                        const id = e.target.getAttribute('data-id');
                        const item = cart.find(item => item.id === id);
                        const newDays = parseInt(e.target.value);
                        if (newDays >= 1) {
                            item.days = newDays;
                            updateCart();
                        } else {
                            e.target.value = item.days;
                        }
                    });
                });
                
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const id = e.target.getAttribute('data-id');
                        cart = cart.filter(item => item.id !== id);
                        updateCart();
                    });
                });
            }
        }

        // Login/Signup functionality
document.querySelectorAll('.login-btn, .signup-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const isLogin = btn.classList.contains('login-btn');
        alert(isLogin ? "Login form will open here!" : "Sign up form will open here!");
        // You can replace this with actual login/signup code later
    });
});
    </script>
    <script src="assets/css/style.css"></script>
    <script src="assets/js/comp.js"></script>
</body>
</html>