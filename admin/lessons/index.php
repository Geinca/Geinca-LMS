<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT lessons.*, courses.title as course_title FROM lessons LEFT JOIN courses ON lessons.course_id = courses.id ORDER BY lessons.position ASC");
$lessons = $stmt->fetchAll();
?>
<div class="main-content">
    <h2 style="opacity: 0;">Lessons</h2>
    <a href="create.php" class="btn btn-primary mb-3"><i class="bi bi-plus"></i> Add New Lesson</a>
    
    <div class="table-container">
        <div class="table-responsive">

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
 </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>



<style>
    /* Main content area with sidebar */
.main-content {
    margin-left: 250px; /* Match with your sidebar width */
    padding: 2rem;
    transition: all 0.3s ease;
    overflow-x: auto; /* For horizontal scrolling on small screens */
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Table container */
.table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 1rem;
    overflow: hidden;
}

/* Table styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
    font-weight: 600;
    padding: 12px;
    text-align: left;
    white-space: nowrap;
}

.table td, .table th {
    padding: 12px;
    vertical-align: middle;
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
        padding: 1.5rem;
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
    .table td:nth-child(1), /* ID */
    .table td:nth-child(5), /* Position */
    .table th:nth-child(1),
    .table th:nth-child(5) {
        display: none;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 1rem;
    }
    
    .table-container {
        padding: 0.5rem;
        box-shadow: none;
        border-radius: 0;
    }
    
    /* Hide more columns on small screens */
    .table td:nth-child(4), /* Duration */
    .table th:nth-child(4) {
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