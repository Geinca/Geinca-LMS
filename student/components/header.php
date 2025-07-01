<?php
/**
 * Header Component
 * 
 * @param string $logoText The text to display next to the logo (default: "Unique Digital")
 * @param string $userInitials The user's initials for the avatar (default: "JS")
 * @param int $cartCount The number of items in cart (default: 0)
 */
function render_header($logoText = "Unique Digital", $userInitials = "JS", $cartCount = 0) {
    ?>
    <header id="header">
        <nav class="navbar">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span><?php echo htmlspecialchars($logoText); ?></span>
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
                
                <div class="cart-icon" id="cartIcon" style="opacity: <?php echo $cartCount > 0 ? '1' : '0'; ?>;">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount"><?php echo $cartCount; ?></span>
                </div>
                
                <div class="user-avatar" id="userAvatar"><?php echo htmlspecialchars($userInitials); ?></div>
                
                <button class="mobile-nav-btn" id="mobileNavBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </header>
    
    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
    
    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span><?php echo htmlspecialchars($logoText); ?></span>
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
    
    <!-- Link to the header CSS -->
    <link rel="stylesheet" href="/assets/css/navpro.css">
    
    <!-- Link to the header JS -->
    <script src="/assets/js/header.js"></script>
    <?php
}
?>