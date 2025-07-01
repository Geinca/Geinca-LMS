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