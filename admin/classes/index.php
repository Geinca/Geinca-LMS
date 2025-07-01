<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Fetch all classes
$stmt = $pdo->query("SELECT * FROM classes ORDER BY created_at DESC");
$classes = $stmt->fetchAll();
?>
<div class="main-content">
    <h2>Classes</h2>
    <a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Class</a>
    
    <div class="table-responsive">
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
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>


<style>
    /* Main content area - accounting for sidebar */
.main-content {
    margin-left: 250px; /* Adjust this to match your sidebar width */
    padding: 20px;
    transition: margin-left 0.3s ease;
}

/* Table styling */
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-collapse: collapse;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.02);
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #dee2e6;
}

/* Button styling */
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-warning {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.mb-3 {
    margin-bottom: 1rem !important;
}

/* Responsive table adjustments */
@media (max-width: 992px) {
    .main-content {
        margin-left: 0;
        padding: 15px;
    }
}

@media (max-width: 768px) {
    /* Make table scroll horizontally on small screens */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Adjust table font sizes */
    .table {
        font-size: 0.9rem;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.7rem;
    }
}

@media (max-width: 576px) {
    /* Stack buttons vertically on very small screens */
    .table td:last-child {
        white-space: normal;
    }
    
    .btn-sm {
        display: block;
        margin-bottom: 0.25rem;
        width: 100%;
    }
    
    /* Reduce padding in table cells */
    .table td, .table th {
        padding: 0.5rem;
    }
    
    /* Hide less important columns on mobile */
    .table td:nth-child(4), /* Price */
    .table td:nth-child(6), /* Created At */
    .table th:nth-child(4),
    .table th:nth-child(6) {
        display: none;
    }
}

/* For screens between 576px and 768px */
@media (min-width: 576px) and (max-width: 768px) {
    /* Show all columns but make them compact */
    .table td, .table th {
        padding: 0.4rem;
        font-size: 0.8rem;
    }
}
</style>