<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
$stmt->execute([$id]);
$class = $stmt->fetch();

if (!$class) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instructor_id = $_POST['instructor_id'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $requirements = $_POST['requirements'];
    $what_you_learn = $_POST['what_you_learn'];
    
    $stmt = $pdo->prepare("UPDATE classes SET title = ?, description = ?, instructor_id = ?, price = ?, category_id = ?, is_published = ?, requirements = ?, what_you_learn = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$title, $description, $instructor_id, $price, $category_id, $is_published, $requirements, $what_you_learn, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<div class="main-content">
    <div class="form-container">
<h2>Edit Class</h2>
<form method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($class['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($class['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="instructor_id" class="form-label">Instructor ID</label>
        <input type="number" class="form-control" id="instructor_id" name="instructor_id" value="<?= htmlspecialchars($class['instructor_id']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($class['price']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category ID</label>
        <input type="number" class="form-control" id="category_id" name="category_id" value="<?= htmlspecialchars($class['category_id']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="requirements" class="form-label">Requirements</label>
        <textarea class="form-control" id="requirements" name="requirements" rows="3"><?= htmlspecialchars($class['requirements']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="what_you_learn" class="form-label">What You'll Learn</label>
        <textarea class="form-control" id="what_you_learn" name="what_you_learn" rows="3"><?= htmlspecialchars($class['what_you_learn']) ?></textarea>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" <?= $class['is_published'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="is_published">Publish this class</label>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
 </div>
</div>
<?php require_once '../includes/footer.php'; ?>



<style>
    /* Main content area - accounting for sidebar */
.main-content {
    margin-left: 250px; /* Adjust to match your sidebar width */
    padding: 2rem;
    transition: all 0.3s ease;
}

/* Form container */
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

/* Form headings */
h2 {
    color: #343a40;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

/* Form labels */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
}

/* Form inputs */
.form-control {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
}

/* Textareas */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* Checkbox styling */
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.form-check-input {
    width: 1.2em;
    height: 1.2em;
    margin-right: 0.5rem;
    margin-top: 0;
}

.form-check-label {
    margin-bottom: 0;
}

/* Button styling */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.625rem 1.25rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
    cursor: pointer;
    margin-right: 0.75rem;
}

.btn-primary {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5c636a;
    border-color: #565e64;
}

/* Spacing utilities */
.mb-3 {
    margin-bottom: 1.5rem !important;
}

/* Responsive adjustments */
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
        padding: 0.625rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
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
    
    .form-control {
        font-size: 0.9rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.75rem;
        margin-right: 0;
    }
    
    /* Stack buttons vertically on mobile */
    .btn-group {
        display: flex;
        flex-direction: column;
    }
}
</style>