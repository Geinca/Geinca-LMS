<?php
require_once '../../auth/db.php';
session_start();

// Restrict non-admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../../auth/login.php');
  exit;
}

// Fetch subjects with course and teacher names
$subjects = $pdo->query("
  SELECT 
    s.subject_id, 
    s.name AS subject_name,
    c.course_name,
    u.name AS teacher_name
  FROM subjects s
  JOIN courses c ON s.course_id = c.course_id
  JOIN teachers t ON s.teacher_id = t.teacher_id
  JOIN users u ON t.teacher_id = u.user_id
  ORDER BY s.name
")->fetchAll(PDO::FETCH_ASSOC);

$class_id = $_GET['id'] ?? null;
$editing = false;

if ($class_id) {
  $stmt = $pdo->prepare("SELECT * FROM classes WHERE class_id = ?");
  $stmt->execute([$class_id]);
  $class = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($class) {
    $editing = true;
  } else {
    die("Class not found.");
  }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subject_id   = $_POST['subject_id'];
  $class_name   = $_POST['class_name'];
  $class_date   = $_POST['class_date'];
  $start_time   = $class_date . ' ' . $_POST['start_time'] . ':00';
  $end_time     = $class_date . ' ' . $_POST['end_time'] . ':00';
  $meeting_link = $_POST['meeting_link'];

  if ($editing) {
    $stmt = $pdo->prepare("
      UPDATE classes 
      SET subject_id = ?, class_name = ?, class_date = ?, start_time = ?, end_time = ?, meeting_link = ? 
      WHERE class_id = ?
    ");
    $stmt->execute([$subject_id, $class_name, $class_date, $start_time, $end_time, $meeting_link, $class_id]);
  } else {
    $stmt = $pdo->prepare("
      INSERT INTO classes (subject_id, class_name, class_date, start_time, end_time, meeting_link) 
      VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$subject_id, $class_name, $class_date, $start_time, $end_time, $meeting_link]);
  }

  header("Location: ../class-timetable.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?= $editing ? 'Edit' : 'Add' ?> Class Slot</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-xl">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">
      <?= $editing ? 'Edit Class Slot' : 'Add Class Slot' ?>
    </h2>
    <form action="" method="POST" class="space-y-4">
      <div>
        <label class="block font-medium text-gray-700">Subject</label>
        <select name="subject_id" required class="w-full border px-4 py-2 rounded">
          <option value="">-- Select Subject --</option>
          <?php foreach ($subjects as $sub): ?>
            <option value="<?= $sub['subject_id'] ?>"
              <?= ($editing && $class['subject_id'] == $sub['subject_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($sub['subject_name']) ?> - <?= htmlspecialchars($sub['course_name']) ?> (<?= htmlspecialchars($sub['teacher_name']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block font-medium text-gray-700">Class Name</label>
        <input type="text" name="class_name" required value="<?= $editing ? htmlspecialchars($class['class_name']) : '' ?>"
          class="w-full border px-4 py-2 rounded" />
      </div>

      <!-- Date -->
      <div>
        <label class="block font-medium text-gray-700">Date</label>
        <input type="date" name="class_date" required value="<?= $editing ? $class['class_date'] : '' ?>"
          class="w-full border px-4 py-2 rounded" />
      </div>

      <div>
        <label class="block font-medium text-gray-700">Start Time</label>
        <input type="time" name="start_time" required value="<?= $editing ? $class['start_time'] : '' ?>"
          class="w-full border px-4 py-2 rounded" />
      </div>

      <div>
        <label class="block font-medium text-gray-700">End Time</label>
        <input type="time" name="end_time" required value="<?= $editing ? $class['end_time'] : '' ?>"
          class="w-full border px-4 py-2 rounded" />
      </div>

      <div>
        <label class="block font-medium text-gray-700">Meeting Link</label>
        <input type="url" name="meeting_link" placeholder="https://..."
          value="<?= $editing ? htmlspecialchars($class['meeting_link']) : '' ?>"
          class="w-full border px-4 py-2 rounded" />
      </div>

      <div class="flex justify-end space-x-2">
        <a href="../class-timetable.php" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <?= $editing ? 'Update' : 'Add' ?>
        </button>
      </div>
    </form>
  </div>
</body>

</html>