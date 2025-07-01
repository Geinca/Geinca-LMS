<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Count stats
$classesCount = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$coursesCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$lessonsCount = $pdo->query("SELECT COUNT(*) FROM lessons")->fetchColumn();
?>

<h1 style="opacity: 0;">Admin Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Classes</h5>
                <p class="card-text display-4"><?= $classesCount ?></p>
                <a href="classes/" class="text-white">View all classes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Courses</h5>
                <p class="card-text display-4"><?= $coursesCount ?></p>
                <a href="courses/" class="text-white">View all courses</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Lessons</h5>
                <p class="card-text display-4"><?= $lessonsCount ?></p>
                <a href="lessons/" class="text-white">View all lessons</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>




<style>
    /* Base Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        padding: 20px 20px 20px calc(250px + 20px); /* 250px for sidebar + 20px padding */
        min-height: 100vh;
    }
    
    h1 {
        color: #343a40;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: left; /* Changed from center to left */
    }
    
    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .card-text {
        font-weight: 300;
        margin-bottom: 1.5rem;
    }
    
    .card a {
        margin-top: auto;
        align-self: flex-start;
        text-decoration: none;
        font-weight: 500;
        position: relative;
        padding-bottom: 3px;
    }
    
    .card a:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: white;
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }
    
    .card a:hover:after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    
    /* Color Variations */
    .bg-primary {
        background-color: #4e73df !important;
    }
    
    .bg-success {
        background-color: #1cc88a !important;
    }
    
    .bg-info {
        background-color: #36b9cc !important;
    }
    
    /* Grid Layout */
    .row {
        margin-bottom: 30px;
        margin-right: 0;
        margin-left: 0;
    }
    
    .col-md-4 {
        padding: 15px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        body {
            padding-left: 20px; /* Remove sidebar space on smaller screens */
        }
        
        /* Assuming sidebar collapses to icon-only or hides on mobile */
    }
    
    @media (max-width: 768px) {
        h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
        
        .card-text.display-4 {
            font-size: 2.5rem;
        }
        
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 10px;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1200px) {
        .col-md-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        
        .col-md-4:last-child {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        body {
            padding-left: calc(200px + 20px); /* Adjust for narrower sidebar */
        }
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .card:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    .card:nth-child(3) {
        animation-delay: 0.2s;
    }
    
    /* Sidebar-specific adjustments */
    .main-content {
        margin-left: 250px; /* Match this with your sidebar width */
        transition: margin-left 0.3s ease;
    }
    
    @media (max-width: 992px) {
        .main-content {
            margin-left: 0;
        }
    }
</style>