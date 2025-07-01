<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Fetch classes for dropdown
$classes = $pdo->query("SELECT id, title FROM classes")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $instructor_id = $_POST['instructor_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    
    $stmt = $pdo->prepare("INSERT INTO courses (class_id, subject_id, instructor_id, title, description, price, is_published, created_at, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->execute([$class_id, $subject_id, $instructor_id, $title, $description, $price, $is_published, $instructor_id]);
    
    header("Location: index.php");
    exit;
}
?>

<h2>Add New Course</h2>
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
        <label for="class_id" class="form-label">Class</label>
        <select class="form-control" id="class_id" name="class_id" required>
            <option value="">Select Class</option>
            <?php foreach ($classes as $class): ?>
            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="subject_id" class="form-label">Subject ID</label>
        <input type="number" class="form-control" id="subject_id" name="subject_id" required>
    </div>
    <div class="mb-3">
        <label for="instructor_id" class="form-label">Instructor ID</label>
        <input type="number" class="form-control" id="instructor_id" name="instructor_id" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_published" name="is_published">
        <label class="form-check-label" for="is_published">Publish this course</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php require_once '../includes/footer.php'; ?>