<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Fetch all classes
$stmt = $pdo->query("SELECT * FROM classes ORDER BY created_at DESC");
$classes = $stmt->fetchAll();
?>

<h2>Classes</h2>
<a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Class</a>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Instructor ID</th>
            <th>Price</th>
            <th>Published</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($classes as $class): ?>
        <tr>
            <td><?= htmlspecialchars($class['id']) ?></td>
            <td><?= htmlspecialchars($class['title']) ?></td>
            <td><?= htmlspecialchars($class['instructor_id']) ?></td>
            <td>$<?= number_format($class['price'], 2) ?></td>
            <td><?= $class['is_published'] ? 'Yes' : 'No' ?></td>
            <td><?= htmlspecialchars($class['created_at']) ?></td>
            <td>
                <a href="edit.php?id=<?= $class['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $class['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>