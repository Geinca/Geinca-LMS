<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor_id = $_POST['instructor_id'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $requirements = $_POST['requirements'];
    $what_you_learn = $_POST['what_you_learn'];
    
    $stmt = $pdo->prepare("INSERT INTO classes (title, description, instructor_id, price, category_id, is_published, requirements, what_you_learn, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$title, $description, $instructor_id, $price, $category_id, $is_published, $requirements, $what_you_learn]);
    
    header("Location: index.php");
    exit;
}
?>
<div class="main-content">
    <div class="form-container">
<h2>Add New Class</h2>
<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="instructor_id" class="form-label">Instructor ID</label>
        <input type="number" class="form-control" id="instructor_id" name="instructor_id" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category ID</label>
        <input type="number" class="form-control" id="category_id" name="category_id" required>
    </div>
    <div class="mb-3">
        <label for="requirements" class="form-label">Requirements</label>
        <textarea class="form-control" id="requirements" name="requirements" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="what_you_learn" class="form-label">What You'll Learn</label>
        <textarea class="form-control" id="what_you_learn" name="what_you_learn" rows="3"></textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published">
        <label class="form-check-label" for="is_published">Publish this class</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
<?php require_once '../includes/footer.php'; ?>


<style>
    /* Main content area with sidebar consideration */
.main-content {
    margin-left: 250px; /* Match this with your sidebar width */
    padding: 2rem;
    transition: all 0.3s ease;
    min-height: 100vh;
    background-color: #f8f9fa;
}

/* Form container styling */
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Form header */
h2 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    font-weight: 600;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f1f1f1;
}

/* Form elements styling */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Textarea specific styling */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* Checkbox styling */
.form-check {
    display: flex;
    align-items: center;
    margin-top: 1rem;
    margin-bottom: 1.5rem;
}

.form-check-input {
    width: 1.2em;
    height: 1.2em;
    margin-right: 0.5rem;
    margin-top: 0;
}

.form-check-label {
    user-select: none;
    cursor: pointer;
}

/* Button styling */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.375rem;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    margin-right: 0.75rem;
}

.btn i {
    margin-right: 0.5rem;
}

.btn-primary {
    background-color: #3498db;
    color: white;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-1px);
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
    transform: translateY(-1px);
}

/* Spacing utilities */
.mb-3 {
    margin-bottom: 1.5rem !important;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .main-content {
        margin-left: 220px;
    }
}

@media (max-width: 992px) {
    .main-content {
        margin-left: 0;
        padding: 1.5rem;
    }
    
    .form-container {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .form-container {
        padding: 1.25rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    .form-control {
        padding: 0.65rem;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 1rem;
    }
    
    .form-container {
        padding: 1rem;
        box-shadow: none;
        border-radius: 0;
    }
    
    h2 {
        font-size: 1.3rem;
    }
    
    /* Stack buttons vertically on mobile */
    .btn {
        width: 100%;
        margin-bottom: 0.75rem;
        margin-right: 0;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
    }
    
    /* Adjust textareas for mobile */
    textarea.form-control {
        min-height: 100px;
    }
}

/* Animation for form elements */
.form-control, .btn, .form-check-input {
    transition: all 0.3s ease;
}

/* Focus effects */
.form-control:focus, .btn:focus, .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}
</style>