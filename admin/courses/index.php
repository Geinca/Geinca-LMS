<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT courses.*, classes.title as class_title FROM courses LEFT JOIN classes ON courses.class_id = classes.id ORDER BY courses.created_at DESC");
$courses = $stmt->fetchAll();
?>

<div class="main-content">
    <h2>Courses</h2>
    <a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Course</a>
    
    <div class="table-responsive">
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
</div>
</div>
<?php require_once '../includes/footer.php'; ?>



<style>
    /* Main content area with sidebar */
.main-content {
    margin-left: 250px; /* Match with your sidebar width */
    padding: 20px;
    transition: all 0.3s ease;
    overflow-x: auto; /* For horizontal scrolling on small screens */
}

/* Table styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    background-color: transparent;
    font-size: 0.9rem;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
    font-weight: 600;
    padding: 12px;
    text-align: left;
}

.table td, .table th {
    padding: 12px;
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
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
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

/* Icon spacing */
.bi {
    margin-right: 0.25rem;
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
        padding: 15px;
    }
    
    .table {
        font-size: 0.85rem;
    }
    
    .table td, .table th {
        padding: 8px;
    }
}

@media (max-width: 768px) {
    /* Make table horizontally scrollable */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Hide less important columns on medium screens */
    .table td:nth-child(4), /* Instructor ID */
    .table th:nth-child(4) {
        display: none;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 10px;
    }
    
    /* Hide more columns on small screens */
    .table td:nth-child(1), /* ID */
    .table td:nth-child(5), /* Price */
    .table th:nth-child(1),
    .table th:nth-child(5) {
        display: none;
    }
    
    /* Stack buttons vertically */
    .table td:last-child {
        white-space: nowrap;
    }
    
    .btn-sm {
        display: inline-block;
        margin-bottom: 0.25rem;
    }
    
    /* Adjust table header font size */
    .table thead th {
        font-size: 0.8rem;
    }
}

/* For screens between 576px and 768px */
@media (min-width: 576px) and (max-width: 768px) {
    /* Show all columns but make them compact */
    .table td, .table th {
        padding: 6px;
        font-size: 0.8rem;
    }
}

/* Animation for hover effects */
.table tr {
    transition: background-color 0.2s ease;
}

.table tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>