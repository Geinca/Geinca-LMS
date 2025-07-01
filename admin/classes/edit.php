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

<?php require_once '../includes/footer.php'; ?>