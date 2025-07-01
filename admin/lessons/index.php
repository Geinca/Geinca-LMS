<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT lessons.*, courses.title as course_title FROM lessons LEFT JOIN courses ON lessons.course_id = courses.id ORDER BY lessons.position ASC");
$lessons = $stmt->fetchAll();
?>

<h2>Lessons</h2>
<a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Lesson</a>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Course</th>
            <th>Duration</th>
            <th>Position</th>
            <th>Preview</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lessons as $lesson): ?>
        <tr>
            <td><?= htmlspecialchars($lesson['id']) ?></td>
            <td><?= htmlspecialchars($lesson['title']) ?></td>
            <td><?= htmlspecialchars($lesson['course_title'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($lesson['duration']) ?></td>
            <td><?= htmlspecialchars($lesson['position']) ?></td>
            <td><?= $lesson['is_preview'] ? 'Yes' : 'No' ?></td>
            <td>
                <a href="edit.php?id=<?= $lesson['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $lesson['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>