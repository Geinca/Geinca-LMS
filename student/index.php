<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Online Courses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/navpro.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Add these styles for the login modal */
        .auth-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
        }
        
        .auth-modal {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .auth-tabs {
            display: flex;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #ddd;
        }
        
        .auth-tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }
        
        .auth-tab.active {
            border-bottom: 2px solid #6c63ff;
            color: #6c63ff;
            font-weight: bold;
        }
        
        .auth-form {
            display: none;
        }
        
        .auth-form.active {
            display: block;
        }
        
        .auth-form input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .auth-form button {
            width: 100%;
            padding: 0.75rem;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        
        .auth-form button:hover {
            background-color: #5a52d6;
        }
        
        .auth-switch {
            text-align: center;
            margin-top: 1rem;
            color: #666;
        }
        
        .auth-switch a {
            color: #6c63ff;
            cursor: pointer;
        }
        
        .close-auth {
            float: right;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #666;
        }
        
        .login-required {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1001;
            display: none;
            text-align: center;
            max-width: 90%;
            width: 300px;
        }
        
        .login-required button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Tab Navigation */
.tab-nav {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.tab-btn {
    padding: 10px 20px;
    background: #f1f1f1;
    border: none;
    cursor: pointer;
    border-radius: 5px 5px 0 0;
    transition: all 0.3s;
}

.tab-btn:hover {
    background: #ddd;
}

.tab-btn.active {
    background: #4CAF50;
    color: white;
}

/* Tab Content */
.tab-content {
    display: none;
    padding: 20px 0;
}

.tab-content.active {
    display: block;
}

/* Course Grid */
.course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}
    </style>
</head>
<body>
    <!-- Header with Sticky Navigation -->
    <header id="header">
        <nav class="navbar">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>Unique Digital</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="#">Categories</a></li>
                <li><a href="#">My Learning</a></li>
                <li><a href="#">Teach</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#" class="login-btn" id="navLoginBtn">Login</a></li>
                <li><a href="#" class="signup-btn" id="navSignupBtn">Sign Up</a></li>
            </ul>
            
            <div class="nav-actions">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for courses">
                </div>
                
                <div class="cart-icon" id="cartIcon" style="opacity: 0;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
                
                <div class="user-avatar" id="userAvatar">JS</div>
                
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
            <li><a href="#" class="login-btn" id="mobileLoginBtn">Login</a></li>
            <li><a href="#" class="signup-btn" id="mobileSignupBtn">Sign Up</a></li>
        </ul>
    </div>
    
    <!-- Login Required Popup -->
    <div class="login-required" id="loginRequired">
        <h3>Login Required</h3>
        <p>Please login or sign up to add courses to your cart.</p>
        <button id="goToLoginBtn">Go to Login</button>
    </div>
    
    <!-- Authentication Modal -->
    <div class="auth-overlay" id="authOverlay">
        <div class="auth-modal">
            <button class="close-auth" id="closeAuth">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="auth-tabs">
                <div class="auth-tab active" data-tab="login">Login</div>
                <div class="auth-tab" data-tab="signup">Sign Up</div>
            </div>
            
            <div class="auth-form active" id="loginForm">
                <input type="email" id="loginEmail" placeholder="Email" required>
                <input type="password" id="loginPassword" placeholder="Password" required>
                <button id="loginSubmit">Login</button>
                <div class="auth-switch">
                    Don't have an account? <a id="switchToSignup">Sign up</a>
                </div>
            </div>
            
            <div class="auth-form" id="signupForm">
                <input type="text" id="signupName" placeholder="Full Name" required>
                <input type="email" id="signupEmail" placeholder="Email" required>
                <input type="password" id="signupPassword" placeholder="Password" required>
                <input type="password" id="signupConfirmPassword" placeholder="Confirm Password" required>
                <button id="signupSubmit">Sign Up</button>
                <div class="auth-switch">
                    Already have an account? <a id="switchToLogin">Login</a>
                </div>
            </div>
        </div>
    </div>

    <div id="hero"></div>
    <div id="stats"></div>
    
    <!-- Main Content -->
    <div class="container">
        <h1>Class Courses</h1>
        
        <!-- Course Tabs -->
       <?php
// Connect to database (example using PDO)
$pdo = new PDO('mysql:host=localhost;dbname=lms', 'root', '');

// Fetch all classes
$classesQuery = $pdo->query("SELECT id, title FROM classes WHERE is_published = 1");
$classes = $classesQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="tabs">
    <?php foreach ($classes as $index => $class): ?>
        <div class="tab <?= $index === 0 ? 'active' : '' ?>" data-tab="class<?= $class['id'] ?>">
            <?= htmlspecialchars($class['title']) ?>
        </div>
    <?php endforeach; ?>
</div>
        
        <!-- Class 8 Courses -->
<!-- Class Tabs Section -->
<div class="class-tabs">
    <?php
    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=lms', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all published classes
    $classesQuery = $pdo->query("SELECT id, title FROM classes WHERE is_published = 1");
    $classes = $classesQuery->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Tabs Navigation -->
    <div class="tab-nav">
        <?php foreach ($classes as $index => $class): ?>
            <button class="tab-btn <?= $index === 0 ? 'active' : '' ?>" 
                    onclick="openTab(event, 'class<?= $class['id'] ?>')">
                <?= htmlspecialchars($class['title']) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Tabs Content -->
    <div class="tabs-content">
        <?php foreach ($classes as $index => $class): ?>
            <div id="class<?= $class['id'] ?>" class="tab-content <?= $index === 0 ? 'active' : '' ?>">
                <div class="course-grid">
                    <?php
                    try {
                        // Fetch published courses for this class with instructor information
                        $coursesQuery = $pdo->prepare("
                            SELECT 
                                c.id, 
                                c.class_id,
                                c.title, 
                                c.description, 
                                c.price,
                                c.thumbnail,
                                u.name AS instructor_name
                            FROM courses c
                            LEFT JOIN users u ON c.instructor_id = u.id
                            WHERE c.class_id = ? AND c.is_published = 1
                        ");
                        $coursesQuery->execute([$class['id']]);
                        $courses = $coursesQuery->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (empty($courses)) {
                            echo "<p>No published courses available for this class.</p>";
                        }
                        
                        foreach ($courses as $course):
                            // Format price
                            $formattedPrice = number_format($course['price'], 2);
                    ?>
                        <div class="course-card">
                            <a href="./classes.php?id=<?= $course['id'] ?>&class_id=<?= $class['id'] ?>" class="course-link">
                                <img src="<?= htmlspecialchars($course['thumbnail'] ?? 'assets/images/default-course.jpg') ?>" 
                                     alt="<?= htmlspecialchars($course['title']) ?>" class="course-img">
                                <div class="course-info">
                                    <h3 class="course-title"><?= htmlspecialchars($course['title']) ?></h3>
                                    <p class="course-instructor">By <?= htmlspecialchars($course['instructor_name'] ?? 'Unknown Instructor') ?></p>
                                    <p class="course-price">₹<?= $formattedPrice ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php } catch (PDOException $e) { ?>
                        <div class="error">
                            Error loading courses: <?= htmlspecialchars($e->getMessage()) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach; ?>
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
        // Check if user is logged in
        function isLoggedIn() {
            return localStorage.getItem('loggedIn') === 'true';
        }
        
        // Update UI based on login status
        function updateLoginStatus() {
            const loggedIn = isLoggedIn();
            const loginButtons = document.querySelectorAll('.login-btn');
            const signupButtons = document.querySelectorAll('.signup-btn');
            const userAvatar = document.getElementById('userAvatar');
            
            if (loggedIn) {
                const userName = localStorage.getItem('userName') || 'User';
                userAvatar.textContent = userName.charAt(0).toUpperCase();
                loginButtons.forEach(btn => btn.style.display = 'none');
                signupButtons.forEach(btn => btn.style.display = 'none');
            } else {
                userAvatar.textContent = 'JS';
                loginButtons.forEach(btn => btn.style.display = 'inline-block');
                signupButtons.forEach(btn => btn.style.display = 'inline-block');
            }
        }
        
        // Initialize login status
        updateLoginStatus();
        
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
            if (!isLoggedIn()) {
                showLoginRequired();
                return;
            }
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
                if (!isLoggedIn()) {
                    showLoginRequired();
                    return;
                }
                
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
            // Save cart to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
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
        
        // Load cart from localStorage
        function loadCart() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCart();
            }
        }
        
        // Initialize cart
        loadCart();
 
        
        // Check if user is logged in
function checkAuthStatus() {
    fetch('auth/check_auth.php')
        .then(response => response.json())
        .then(data => {
            if (data.authenticated) {
                localStorage.setItem('loggedIn', 'true');
                localStorage.setItem('userName', data.user.name);
                localStorage.setItem('userEmail', data.user.email);
            } else {
                localStorage.removeItem('loggedIn');
                localStorage.removeItem('userName');
                localStorage.removeItem('userEmail');
            }
            updateLoginStatus();
        })
        .catch(error => {
            console.error('Error checking auth status:', error);
        });
}

// Update UI based on login status
function updateLoginStatus() {
    const loggedIn = localStorage.getItem('loggedIn') === 'true';
    const loginButtons = document.querySelectorAll('.login-btn');
    const signupButtons = document.querySelectorAll('.signup-btn');
    const userAvatar = document.getElementById('userAvatar');
    
    if (loggedIn) {
        const userName = localStorage.getItem('userName') || 'User';
        userAvatar.textContent = userName.charAt(0).toUpperCase();
        loginButtons.forEach(btn => btn.style.display = 'none');
        signupButtons.forEach(btn => btn.style.display = 'none');
        
        // Add logout functionality to avatar
        userAvatar.onclick = function() {
            fetch('auth/logout.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('loggedIn');
                        localStorage.removeItem('userName');
                        localStorage.removeItem('userEmail');
                        updateLoginStatus();
                        window.location.reload(); // Refresh to update the UI
                    }
                });
        };
    } else {
        userAvatar.textContent = 'JS';
        loginButtons.forEach(btn => btn.style.display = 'inline-block');
        signupButtons.forEach(btn => btn.style.display = 'inline-block');
        
        // Remove logout functionality
        userAvatar.onclick = null;
    }
}

// Initialize auth status
checkAuthStatus();

// Authentication Modal
const authOverlay = document.getElementById('authOverlay');
const closeAuth = document.getElementById('closeAuth');
const authTabs = document.querySelectorAll('.auth-tab');
const authForms = document.querySelectorAll('.auth-form');
const switchToSignup = document.getElementById('switchToSignup');
const switchToLogin = document.getElementById('switchToLogin');
const loginSubmit = document.getElementById('loginSubmit');
const signupSubmit = document.getElementById('signupSubmit');
const loginRequired = document.getElementById('loginRequired');
const goToLoginBtn = document.getElementById('goToLoginBtn');

// Show login required popup
function showLoginRequired() {
    loginRequired.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Hide login required popup
function hideLoginRequired() {
    loginRequired.style.display = 'none';
    document.body.style.overflow = '';
}

// Open auth modal
function openAuthModal(tab = 'login') {
    authOverlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Set active tab
    authTabs.forEach(t => t.classList.remove('active'));
    authForms.forEach(f => f.classList.remove('active'));
    
    if (tab === 'login') {
        document.querySelector('.auth-tab[data-tab="login"]').classList.add('active');
        document.getElementById('loginForm').classList.add('active');
    } else {
        document.querySelector('.auth-tab[data-tab="signup"]').classList.add('active');
        document.getElementById('signupForm').classList.add('active');
    }
}

// Close auth modal
function closeAuthModal() {
    authOverlay.style.display = 'none';
    document.body.style.overflow = '';
}

// Switch between login and signup tabs
authTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        authTabs.forEach(t => t.classList.remove('active'));
        authForms.forEach(f => f.classList.remove('active'));
        
        tab.classList.add('active');
        const tabId = tab.getAttribute('data-tab');
        document.getElementById(tabId + 'Form').classList.add('active');
    });
});

// Switch to signup from login
switchToSignup.addEventListener('click', (e) => {
    e.preventDefault();
    authTabs.forEach(t => t.classList.remove('active'));
    authForms.forEach(f => f.classList.remove('active'));
    
    document.querySelector('.auth-tab[data-tab="signup"]').classList.add('active');
    document.getElementById('signupForm').classList.add('active');
});

// Switch to login from signup
switchToLogin.addEventListener('click', (e) => {
    e.preventDefault();
    authTabs.forEach(t => t.classList.remove('active'));
    authForms.forEach(f => f.classList.remove('active'));
    
    document.querySelector('.auth-tab[data-tab="login"]').classList.add('active');
    document.getElementById('loginForm').classList.add('active');
});

// Close auth modal
closeAuth.addEventListener('click', closeAuthModal);

// Login form submission
loginSubmit.addEventListener('click', () => {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    if (!email || !password) {
        alert('Please fill in all fields');
        return;
    }
    
    fetch('auth/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('loggedIn', 'true');
            localStorage.setItem('userName', data.user.name);
            localStorage.setItem('userEmail', data.user.email);
            closeAuthModal();
            updateLoginStatus();
            hideLoginRequired();
            alert('Login successful!');
        } else {
            alert(data.message || 'Login failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during login');
    });
});

// Signup form submission
signupSubmit.addEventListener('click', () => {
    const name = document.getElementById('signupName').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('signupConfirmPassword').value;
    
    if (!name || !email || !password || !confirmPassword) {
        alert('Please fill in all fields');
        return;
    }
    
    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }
    
    fetch('auth/signup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password,
            confirmPassword: confirmPassword
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('loggedIn', 'true');
            localStorage.setItem('userName', data.user.name);
            localStorage.setItem('userEmail', data.user.email);
            closeAuthModal();
            updateLoginStatus();
            hideLoginRequired();
            alert('Account created successfully! You are now logged in.');
        } else {
            alert(data.message || 'Signup failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during signup');
    });
});

// Login buttons
document.querySelectorAll('.login-btn, #mobileLoginBtn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        openAuthModal('login');
    });
});

// Signup buttons
document.querySelectorAll('.signup-btn, #mobileSignupBtn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        openAuthModal('signup');
    });
});

// Go to login from login required popup
goToLoginBtn.addEventListener('click', () => {
    hideLoginRequired();
    openAuthModal('login');
});

// Close login required popup when clicking outside
loginRequired.addEventListener('click', (e) => {
    if (e.target === loginRequired) {
        hideLoginRequired();
    }
});



// Check auth status on page load
document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
});

async function checkAuthStatus() {
    try {
        const response = await fetch('auth/check_auth.php');
        const data = await response.json();
        
        if (data.authenticated) {
            // Update localStorage to match server session
            localStorage.setItem('loggedIn', 'true');
            localStorage.setItem('userName', data.user.name);
            localStorage.setItem('userEmail', data.user.email);
            updateUIForLoggedInUser(data.user);
        } else {
            // Clear localStorage if server says not authenticated
            localStorage.removeItem('loggedIn');
            localStorage.removeItem('userName');
            localStorage.removeItem('userEmail');
            updateUIForLoggedOutUser();
        }
    } catch (error) {
        console.error('Auth check failed:', error);
    }
}

// Call this after successful login
function updateUIForLoggedInUser(user) {
    const userAvatar = document.getElementById('userAvatar');
    userAvatar.textContent = user.name.charAt(0).toUpperCase();
    document.querySelectorAll('.login-btn, .signup-btn').forEach(btn => {
        btn.style.display = 'none';
    });
}

function updateUIForLoggedOutUser() {
    document.getElementById('userAvatar').textContent = 'JS';
    document.querySelectorAll('.login-btn, .signup-btn').forEach(btn => {
        btn.style.display = 'inline-block';
    });
}
    </script>
    <!-- Add this JavaScript at the bottom of your page -->
<script>
function openTab(evt, tabName) {
    // Hide all tab content
    var tabContents = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove("active");
    }

    // Remove active class from all tab buttons
    var tabButtons = document.getElementsByClassName("tab-btn");
    for (var i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove("active");
    }

    // Show the current tab and add active class to the button
    document.getElementById(tabName).classList.add("active");
    evt.currentTarget.classList.add("active");
}
</script>
    <script src="assets/css/style.css"></script>
    <script src="assets/js/comp.js"></script>
</body>
</html>