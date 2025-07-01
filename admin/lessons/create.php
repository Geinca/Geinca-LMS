<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Fetch courses for dropdown
$courses = $pdo->query("SELECT id, title FROM courses")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];
    $duration = $_POST['duration'];
    $position = $_POST['position'];
    $is_preview = isset($_POST['is_preview']) ? 1 : 0;
    $is_live = isset($_POST['is_live']) ? 1 : 0;
    $live_date = $_POST['live_date'] ?: null;
    $live_end = $_POST['live_end'] ?: null;
    
    $stmt = $pdo->prepare("INSERT INTO lessons (course_id, title, description, video_url, duration, position, is_preview, is_live, live_date, live_end, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$course_id, $title, $description, $video_url, $duration, $position, $is_preview, $is_live, $live_date, $live_end]);
    
    header("Location: index.php");
    exit;
}
?>
<div class="main-content">
    <div class="form-container">
        <h2>Add New Lesson</h2>

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
        <label for="course_id" class="form-label">Course</label>
        <select class="form-control" id="course_id" name="course_id" required>
            <option value="">Select Course</option>
            <?php foreach ($courses as $course): ?>
            <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="video_url" class="form-label">Video URL</label>
        <input type="text" class="form-control" id="video_url" name="video_url">
    </div>
    <div class="mb-3">
        <label for="duration" class="form-label">Duration (minutes)</label>
        <input type="number" class="form-control" id="duration" name="duration">
    </div>
    <div class="mb-3">
        <label for="position" class="form-label">Position</label>
        <input type="number" class="form-control" id="position" name="position" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_preview" name="is_preview">
        <label class="form-check-label" for="is_preview">Available as preview</label>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="is_live" name="is_live">
        <label class="form-check-label" for="is_live">Is Live Lesson</label>
    </div>
    <div class="mb-3 live-fields" style="display: none;">
        <label for="live_date" class="form-label">Live Start Date/Time</label>
        <input type="datetime-local" class="form-control" id="live_date" name="live_date">
    </div>
    <div class="mb-3 live-fields" style="display: none;">
        <label for="live_end" class="form-label">Live End Date/Time</label>
        <input type="datetime-local" class="form-control" id="live_end" name="live_end">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
  </div>
</div>
<script>
document.getElementById('is_live').addEventListener('change', function() {
    var liveFields = document.querySelectorAll('.live-fields');
    liveFields.forEach(function(field) {
        field.style.display = this.checked ? 'block' : 'none';
    }.bind(this));
});
</script>

<?php require_once '../includes/footer.php'; ?>



<style>
    /* Main content area with sidebar */
.main-content {
    margin-left: 250px; /* Match with your sidebar width */
    padding: 2rem;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* Form container */
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: #ffffff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

/* Form header */
h2 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
    font-weight: 600;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f1f1f1;
}

/* Form elements */
.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
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
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Select dropdown styling */
select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

/* Textarea styling */
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

/* Date/time input styling */
input[type="datetime-local"].form-control {
    padding: 0.65rem 0.75rem;
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

.btn-primary {
    background-color: #3498db;
    color: white;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-secondary {
    background-color: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Conditional fields styling */
.live-fields {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #3498db;
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
        font-size: 1.4rem;
    }
    
    /* Stack buttons vertically on mobile */
    .btn {
        width: 100%;
        margin-bottom: 0.75rem;
        margin-right: 0;
    }
    
    /* Adjust form elements for mobile */
    .form-control {
        font-size: 0.9rem;
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    /* Adjust datetime inputs for mobile */
    input[type="datetime-local"].form-control {
        padding: 0.55rem;
    }
    
    /* Make live fields more compact */
    .live-fields {
        padding: 0.75rem;
    }
}
</style>