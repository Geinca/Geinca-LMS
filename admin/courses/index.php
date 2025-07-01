<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT courses.*, classes.title as class_title FROM courses LEFT JOIN classes ON courses.class_id = classes.id ORDER BY courses.created_at DESC");
$courses = $stmt->fetchAll();
?>

<h2>Courses</h2>
<a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Course</a>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Class</th>
            <th>Instructor ID</th>
            <th>Price</th>
            <th>Published</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= htmlspecialchars($course['id']) ?></td>
            <td><?= htmlspecialchars($course['title']) ?></td>
            <td><?= htmlspecialchars($course['class_title'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($course['instructor_id']) ?></td>
            <td>₹<?= number_format($course['price'], 2) ?></td>
            <td><?= $course['is_published'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="edit.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>