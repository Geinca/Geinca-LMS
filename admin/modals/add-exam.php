<?php
require_once '../../auth/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../../auth/login.php");
  exit;
}

// Fetch subjects
$subjects = $pdo->query("SELECT subject_id, name FROM subjects")->fetchAll(PDO::FETCH_ASSOC);

// Static class options (or fetch from DB if needed)
$classes = ["6-A", "6-B", "7-A", "7-B", "8-A", "9-A", "9-B", "10-A", "10-B"];

// Edit mode
$exam_id = $_GET['id'] ?? null;
$editing = false;

if ($exam_id) {
  $stmt = $pdo->prepare("SELECT * FROM exams WHERE exam_id = ?");
  $stmt->execute([$exam_id]);
  $exam = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($exam) $editing = true;
  else die("Exam not found.");
}

// Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subject_id = $_POST['subject_id'];
  $class_name = $_POST['class_name'];
  $type = $_POST['type'];
  $exam_date = $_POST['exam_date'];
  $start_time = $_POST['start_time'];
  $duration = $_POST['duration'];

  if ($editing) {
    $stmt = $pdo->prepare("UPDATE exams SET subject_id=?, class_name=?, type=?, exam_date=?, start_time=?, duration=? WHERE exam_id=?");
    $stmt->execute([$subject_id, $class_name, $type, $exam_date, $start_time, $duration, $exam_id]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO exams (subject_id, class_name, type, exam_date, start_time, duration) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$subject_id, $class_name, $type, $exam_date, $start_time, $duration]);
  }
  header("Location: ../exam-manager.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $editing ? "Edit" : "Add" ?> Exam</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800"><?= $editing ? "Edit" : "Schedule" ?> Exam</h2>

    <form method="POST" class="space-y-4">
      <!-- Subject -->
      <div>
        <label class="block text-gray-700 font-medium">Subject</label>
        <select name="subject_id" required class="w-full border px-4 py-2 rounded">
          <option value="">-- Select Subject --</option>
          <?php foreach ($subjects as $s): ?>
            <option value="<?= $s['subject_id'] ?>" <?= ($editing && $s['subject_id'] == $exam['subject_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Class -->
      <div>
        <label class="block text-gray-700 font-medium">Class</label>
        <select name="class_name" required class="w-full border px-4 py-2 rounded">
          <option value="">-- Select Class --</option>
          <?php foreach ($classes as $class): ?>
            <option value="<?= $class ?>" <?= ($editing && $exam['class_name'] == $class) ? 'selected' : '' ?>><?= $class ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Exam Type -->
      <div>
        <label class="block text-gray-700 font-medium">Exam Type</label>
        <input type="text" name="type" required value="<?= $editing ? htmlspecialchars($exam['type']) : '' ?>"
               class="w-full border px-4 py-2 rounded" placeholder="e.g., Mid-Term, Final Exam" />
      </div>

      <!-- Date -->
      <div>
        <label class="block text-gray-700 font-medium">Exam Date</label>
        <input type="date" name="exam_date" required value="<?= $editing ? $exam['exam_date'] : '' ?>"
               class="w-full border px-4 py-2 rounded" />
      </div>

      <!-- Time -->
      <div>
        <label class="block text-gray-700 font-medium">Start Time</label>
        <input type="time" name="start_time" required value="<?= $editing ? $exam['start_time'] : '' ?>"
               class="w-full border px-4 py-2 rounded" />
      </div>

      <!-- Duration -->
      <div>
        <label class="block text-gray-700 font-medium">Duration</label>
        <input type="text" name="duration" required value="<?= $editing ? htmlspecialchars($exam['duration']) : '' ?>"
               class="w-full border px-4 py-2 rounded" placeholder="e.g., 2 hrs" />
      </div>

      <!-- Actions -->
      <div class="flex justify-end gap-2">
        <a href="../exam-manager.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <?= $editing ? "Update Exam" : "Add Exam" ?>
        </button>
      </div>
    </form>
  </div>
</body>
</html>
