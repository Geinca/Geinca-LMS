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

<script>
document.getElementById('is_live').addEventListener('change', function() {
    var liveFields = document.querySelectorAll('.live-fields');
    liveFields.forEach(function(field) {
        field.style.display = this.checked ? 'block' : 'none';
    }.bind(this));
});
</script>

<?php require_once '../includes/footer.php'; ?>