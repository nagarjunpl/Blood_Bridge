<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Include configuration file
require_once 'config.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Determine which page to show
$currentPage = 'login'; // Default page
if ($isLoggedIn) {
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 'home';
} elseif (isset($_GET['page']) && ($_GET['page'] == 'login' || $_GET['page'] == 'signup')) {
    $currentPage = $_GET['page'];
}

// Function to check if a page should be hidden
function isHidden($page) {
    global $currentPage;
    return $page != $currentPage ? 'hidden' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBridge - Connect Blood Donors & Receivers</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Your existing CSS remains the same */
        :root {
            --primary-color: #d32f2f;
            --primary-dark: #b71c1c;
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --dark-gray: #333333;
            --transition: all 0.3s ease;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --box-shadow-hover: 0 8px 25px rgba(211, 47, 47, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark-gray);
            background-color: var(--light-gray);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header Styles */
        header {
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        header.scrolled {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        header.hidden {
            display: none;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo span {
            color: var(--dark-gray);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-gray);
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 20px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: var(--white);
            padding: 180px 0 100px;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: var(--box-shadow-hover);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--white);
        }

        .btn-outline:hover {
            background-color: var(--white);
            color: var(--primary-color);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(211, 47, 47, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(211, 47, 47, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(211, 47, 47, 0);
            }
        }

        /* Section Styles */
        .section {
            padding: 100px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        /* Form Styles */
        .form-container, .auth-form {
            background-color: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: var(--box-shadow);
            max-width: 800px;
            margin: 0 auto;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-form {
            width: 100%;
            max-width: 500px;
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-title h2 {
            font-size: 28px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .form-title p {
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.2);
        }

        .error-message {
            color: var(--primary-color);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Search Section */
        .search-bar {
            display: flex;
            margin-bottom: 30px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
        }

        .search-bar button {
            padding: 0 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-bar button:hover {
            background-color: var(--primary-dark);
        }

        /* Donor List */
        .receiver-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .receiver-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .receiver-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }

        /* Hidden class */
        .hidden {
            display: none !important;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: var(--white);
                flex-direction: column;
                align-items: center;
                padding-top: 30px;
                transition: var(--transition);
            }

            .nav-links.active {
                left: 0;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .hamburger {
                display: block;
            }

            .hero-content h1 {
                font-size: 36px;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }

            .section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header id="header" class="<?php echo $isLoggedIn ? '' : 'hidden'; ?>">
        <div class="container">
            <nav>
                <a href="?page=home" class="logo">Blood<span>Bridge</span></a>
                <ul class="nav-links">
                    <li><a href="?page=home">Home</a></li>
                    <li><a href="?page=search">Find Donors</a></li>
                    <li><a href="?page=donate">Donate Blood</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="hamburger">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Home Page -->
    <section class="hero <?php echo isHidden('home'); ?>" id="home-page">
        <div class="container">
            <div class="hero-content">
                <h1>Saving Lives Through Blood Donation</h1>
                <p>Every drop counts. Join our community of blood donors and help patients in need of life-saving blood transfusions.</p>
                <div class="hero-buttons">
                    <a href="?page=donate" class="btn pulse">Donate Blood</a>
                    <a href="?page=search" class="btn btn-outline">Find Donors</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Form Page -->
    <section class="section <?php echo isHidden('donate'); ?>" id="donate-page">
        <div class="container">
            <div class="form-container">
                <div class="form-title">
                    <h2>Become a Blood Donor</h2>
                    <p>Your donation can save up to 3 lives</p>
                </div>
                
                <form id="donationForm" action="register_donor.php" method="POST">
                    <div class="form-group">
                        <label for="donor-name">Full Name</label>
                        <input type="text" id="donor-name" name="full_name" class="form-control" placeholder="Your Name" value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                        <div class="error-message" id="donor-name-error">Please enter your name</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="donor-email">Email</label>
                        <input type="email" id="donor-email" name="email" class="form-control" placeholder="Your Email" value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                        <div class="error-message" id="donor-email-error">Please enter a valid email</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="donor-phone">Phone Number</label>
                        <input type="tel" id="donor-phone" name="phone" class="form-control" placeholder="Your Phone Number">
                        <div class="error-message" id="donor-phone-error">Please enter your phone number</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="blood-type">Blood Type</label>
                        <select id="blood-type" name="blood_type" class="form-control">
                            <option value="">Select your blood type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                        <div class="error-message" id="blood-type-error">Please select your blood type</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="donor-location">Location (City)</label>
                        <input type="text" id="donor-location" name="location" class="form-control" placeholder="Your City">
                        <div class="error-message" id="donor-location-error">Please enter your location</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="donation-date">Available Donation Date</label>
                        <input type="date" id="donation-date" name="donation_date" class="form-control">
                        <div class="error-message" id="donation-date-error">Please select a date</div>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="eligibility-check" name="eligibility"> I confirm that I meet all eligibility requirements for blood donation
                        </label>
                        <div class="error-message" id="eligibility-error">You must confirm eligibility</div>
                    </div>
                    
                    <button type="submit" class="btn">Register as Donor</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Search Donors Page -->
    <section class="section search-section <?php echo isHidden('search'); ?>" id="search-page">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 30px;">Find Blood Donors</h2>
            
            <div class="search-bar">
                <input type="text" id="donor-search" placeholder="Search by location or blood type...">
                <button onclick="searchDonors()"><i class="fas fa-search"></i> Search</button>
            </div>
            
            <div class="receiver-list" id="donor-list">
                <?php include 'fetch_donors.php'; ?>
            </div>
        </div>
    </section>

    <!-- Login Page -->
    <section class="auth-container <?php echo isHidden('login'); ?>" id="login-page">
        <div class="auth-form">
            <div class="form-title">
                <h2>Login to BloodBridge</h2>
                <p>Welcome back! Please enter your details</p>
            </div>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                <div style="color: red; margin-bottom: 15px; text-align: center;">
                    Invalid email or password. Please try again.
                </div>
            <?php endif; ?>
            
            <form id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" class="form-control" placeholder="Your Email" required>
                    <div class="error-message" id="login-email-error">Please enter a valid email</div>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" class="form-control" placeholder="Your Password" required>
                    <div class="error-message" id="login-password-error">Please enter your password</div>
                </div>
                
                <button type="submit" class="btn">Login</button>
                
                <div class="form-footer">
                    <p>Don't have an account? <a href="?page=signup">Sign up</a></p>
                </div>
            </form>
        </div>
    </section>

    <!-- Signup Page -->
    <section class="auth-container <?php echo isHidden('signup'); ?>" id="signup-page">
        <div class="auth-form">
            <div class="form-title">
                <h2>Create an Account</h2>
                <p>Join our blood donation community</p>
            </div>
            
            <?php if (isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
                <div style="color: red; margin-bottom: 15px; text-align: center;">
                    Email already exists. Please use a different email or login.
                </div>
            <?php endif; ?>
            
            <form id="signupForm" action="register.php" method="POST">
                <div class="form-group">
                    <label for="signup-name">Full Name</label>
                    <input type="text" id="signup-name" name="full_name" class="form-control" placeholder="Your Name" required>
                    <div class="error-message" id="signup-name-error">Please enter your name</div>
                </div>
                
                <div class="form-group">
                    <label for="signup-email">Email</label>
                    <input type="email" id="signup-email" name="email" class="form-control" placeholder="Your Email" required>
                    <div class="error-message" id="signup-email-error">Please enter a valid email</div>
                </div>
                
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" name="password" class="form-control" placeholder="Create Password" required minlength="6">
                    <div class="error-message" id="signup-password-error">Password must be at least 6 characters</div>
                </div>
                
                <div class="form-group">
                    <label for="signup-role">I want to:</label>
                    <select id="signup-role" name="role" class="form-control">
                        <option value="donor">Donate blood</option>
                        <option value="receiver">Find blood donors</option>
                    </select>
                </div>
                
                <button type="submit" class="btn">Create Account</button>
                
                <div class="form-footer">
                    <p>Already have an account? <a href="?page=login">Login</a></p>
                </div>
            </form>
        </div>
    </section>

    <script>
        // Mobile Navigation Toggle
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        if (hamburger && navLinks) {
            hamburger.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                hamburger.innerHTML = navLinks.classList.contains('active') ? 
                    '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
            });

            // Close mobile menu when clicking a link
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                    hamburger.innerHTML = '<i class="fas fa-bars"></i>';
                });
            });
        }

        // Sticky Header on Scroll
        const header = document.getElementById('header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        }

        // Search Donors Functionality
        function searchDonors() {
            const searchTerm = document.getElementById('donor-search').value.toLowerCase();
            const donorCards = document.querySelectorAll('.receiver-card');
            
            donorCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                if (cardText.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Form Validations
        document.getElementById('donationForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateDonationForm()) {
                this.submit();
            }
        });

        function validateDonationForm() {
            let isValid = true;
            
            // Validate donor name
            const donorName = document.getElementById('donor-name');
            if (donorName.value.trim() === '') {
                document.getElementById('donor-name-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('donor-name-error').style.display = 'none';
            }
            
            // Validate donor email
            const donorEmail = document.getElementById('donor-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(donorEmail.value)) {
                document.getElementById('donor-email-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('donor-email-error').style.display = 'none';
            }
            
            // Validate donor phone
            const donorPhone = document.getElementById('donor-phone');
            if (donorPhone.value.trim() === '') {
                document.getElementById('donor-phone-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('donor-phone-error').style.display = 'none';
            }
            
            // Validate blood type
            const bloodType = document.getElementById('blood-type');
            if (bloodType.value === '') {
                document.getElementById('blood-type-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('blood-type-error').style.display = 'none';
            }
            
            // Validate location
            const donorLocation = document.getElementById('donor-location');
            if (donorLocation.value.trim() === '') {
                document.getElementById('donor-location-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('donor-location-error').style.display = 'none';
            }
            
            // Validate donation date
            const donationDate = document.getElementById('donation-date');
            if (donationDate.value === '') {
                document.getElementById('donation-date-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('donation-date-error').style.display = 'none';
            }
            
            // Validate eligibility
            const eligibilityCheck = document.getElementById('eligibility-check');
            if (!eligibilityCheck.checked) {
                document.getElementById('eligibility-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('eligibility-error').style.display = 'none';
            }
            
            return isValid;
        }

        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateLoginForm()) {
                this.submit();
            }
        });

        function validateLoginForm() {
            let isValid = true;
            
            // Validate login email
            const loginEmail = document.getElementById('login-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(loginEmail.value)) {
                document.getElementById('login-email-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('login-email-error').style.display = 'none';
            }
            
            // Validate login password
            const loginPassword = document.getElementById('login-password');
            if (loginPassword.value.trim() === '') {
                document.getElementById('login-password-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('login-password-error').style.display = 'none';
            }
            
            return isValid;
        }

        document.getElementById('signupForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateSignupForm()) {
                this.submit();
            }
        });

        function validateSignupForm() {
            let isValid = true;
            
            // Validate signup name
            const signupName = document.getElementById('signup-name');
            if (signupName.value.trim() === '') {
                document.getElementById('signup-name-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('signup-name-error').style.display = 'none';
            }
            
            // Validate signup email
            const signupEmail = document.getElementById('signup-email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(signupEmail.value)) {
                document.getElementById('signup-email-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('signup-email-error').style.display = 'none';
            }
            
            // Validate signup password
            const signupPassword = document.getElementById('signup-password');
            if (signupPassword.value.length < 6) {
                document.getElementById('signup-password-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('signup-password-error').style.display = 'none';
            }
            
            return isValid;
        }
    </script>
</body>
</html>