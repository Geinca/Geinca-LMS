<?php
require_once 'C:/xampp/htdocs/geinca/Geinca-LMS/db.php';

class ClassManager {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAllClasses() {
        return $this->pdo->query("SELECT * FROM classes ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createClass($name) {
        $stmt = $this->pdo->prepare("INSERT INTO classes (name) VALUES (?)");
        return $stmt->execute([$name]);
    }
}

class SubjectManager {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getSubjectsByClass($class_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM subjects WHERE class_id = ? ORDER BY name");
        $stmt->execute([$class_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllSubjects() {
        return $this->pdo->query("SELECT * FROM subjects ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createSubject($class_id, $name) {
        $stmt = $this->pdo->prepare("INSERT INTO subjects (class_id, name) VALUES (?, ?)");
        return $stmt->execute([$class_id, $name]);
    }
}

class UserManager {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getAllInstructors() {
        return $this->pdo->query("SELECT * FROM users WHERE role = 'instructor' ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllStudents() {
        return $this->pdo->query("SELECT * FROM users WHERE role = 'student' ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createUser($name, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $role]);
    }
}

class CourseManager {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function createCourse($class_id, $subject_id, $instructor_id, $title, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO courses (class_id, subject_id, instructor_id, title, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$class_id, $subject_id, $instructor_id, $title, $description]);
    }
    public function updateCourse($id, $class_id, $subject_id, $instructor_id, $title, $description) {
        $stmt = $this->pdo->prepare("UPDATE courses SET class_id = ?, subject_id = ?, instructor_id = ?, title = ?, description = ? WHERE id = ?");
        return $stmt->execute([$class_id, $subject_id, $instructor_id, $title, $description, $id]);
    }
    public function deleteCourse($id) {
        $stmt = $this->pdo->prepare("DELETE FROM courses WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function getAllCourses() {
        $query = "SELECT c.*, cl.name as class_name, s.name as subject_name, u.name as instructor_name 
                  FROM courses c
                  LEFT JOIN classes cl ON c.class_id = cl.id
                  LEFT JOIN subjects s ON c.subject_id = s.id
                  LEFT JOIN users u ON c.instructor_id = u.id
                  ORDER BY c.id DESC";
        return $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Initialize all managers
$classManager = new ClassManager($pdo);
$subjectManager = new SubjectManager($pdo);
$userManager = new UserManager($pdo);
$courseManager = new CourseManager($pdo);

// Get all options for dropdowns
$classes = $classManager->getAllClasses();
$subjects = $subjectManager->getAllSubjects();
$instructors = $userManager->getAllInstructors();
$students = $userManager->getAllStudents();

// Handle form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_course'])) {
        $courseManager->createCourse($_POST['class_id'], $_POST['subject_id'], $_POST['instructor_id'], $_POST['title'], $_POST['description']);
    } elseif (isset($_POST['edit_course'])) {
        $courseManager->updateCourse($_POST['course_id'], $_POST['class_id'], $_POST['subject_id'], $_POST['instructor_id'], $_POST['title'], $_POST['description']);
    } elseif (isset($_POST['add_class'])) {
        $classManager->createClass($_POST['class_name']);
    } elseif (isset($_POST['add_subject'])) {
        $subjectManager->createSubject($_POST['subject_class_id'], $_POST['subject_name']);
    } elseif (isset($_POST['add_instructor'])) {
        $userManager->createUser($_POST['instructor_name'], $_POST['instructor_email'], $_POST['instructor_password'], 'instructor');
    } elseif (isset($_POST['add_student'])) {
        $userManager->createUser($_POST['student_name'], $_POST['student_email'], $_POST['student_password'], 'student');
    }
}
if (isset($_GET['delete'])) {
    $courseManager->deleteCourse($_GET['delete']);
}

$courses = $courseManager->getAllCourses();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Course Management</h1>

        <!-- Action Buttons -->
        <div class="flex space-x-2 mb-4">
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Course</button>
            <button onclick="document.getElementById('addClassModal').classList.remove('hidden')" class="bg-purple-600 text-white px-4 py-2 rounded">+ Add Class</button>
            <button onclick="document.getElementById('addSubjectModal').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Subject</button>
            <button onclick="document.getElementById('addInstructorModal').classList.remove('hidden')" class="bg-yellow-600 text-white px-4 py-2 rounded">+ Add Instructor</button>
            <button onclick="document.getElementById('addStudentModal').classList.remove('hidden')" class="bg-red-600 text-white px-4 py-2 rounded">+ Add Student</button>
        </div>

        <!-- Course Table -->
        <table class="min-w-full bg-white shadow rounded overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Class</th>
                    <th class="py-2 px-4">Subject</th>
                    <th class="py-2 px-4">Instructor</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?= $course['id'] ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($course['title']) ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($course['class_name'] ?? 'N/A') ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($course['subject_name'] ?? 'N/A') ?></td>
                        <td class="px-4 py-2"><?= htmlspecialchars($course['instructor_name'] ?? 'N/A') ?></td>
                        <td class="px-4 py-2 space-x-2">
                            <button onclick='openEditModal(<?= json_encode($course) ?>)' class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                            <a href="?delete=<?= $course['id'] ?>" onclick="return confirm('Are you sure to delete this?')" class="bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Course Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Add Course</h2>
            <input type="hidden" name="add_course" value="1">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Class</label>
                <select name="class_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <select name="subject_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Instructor</label>
                <select name="instructor_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Instructor</option>
                    <?php foreach ($instructors as $instructor): ?>
                        <option value="<?= $instructor['id'] ?>"><?= htmlspecialchars($instructor['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" placeholder="Course Title" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" placeholder="Description" class="w-full border p-2 rounded" required></textarea>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
            </div>
        </form>
    </div>

    <!-- Add Class Modal -->
    <div id="addClassModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Add New Class</h2>
            <input type="hidden" name="add_class" value="1">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Class Name</label>
                <input type="text" name="class_name" placeholder="Class Name" class="w-full border p-2 rounded" required>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addClassModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-purple-600 text-white px-4 py-2 rounded">Add Class</button>
            </div>
        </form>
    </div>

    <!-- Add Subject Modal -->
    <div id="addSubjectModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Add New Subject</h2>
            <input type="hidden" name="add_subject" value="1">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Class</label>
                <select name="subject_class_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject Name</label>
                <input type="text" name="subject_name" placeholder="Subject Name" class="w-full border p-2 rounded" required>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addSubjectModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded">Add Subject</button>
            </div>
        </form>
    </div>

    <!-- Add Instructor Modal -->
    <div id="addInstructorModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Add New Instructor</h2>
            <input type="hidden" name="add_instructor" value="1">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="instructor_name" placeholder="Instructor Name" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="instructor_email" placeholder="Instructor Email" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="instructor_password" placeholder="Password" class="w-full border p-2 rounded" required>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addInstructorModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-yellow-600 text-white px-4 py-2 rounded">Add Instructor</button>
            </div>
        </form>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Add New Student</h2>
            <input type="hidden" name="add_student" value="1">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="student_name" placeholder="Student Name" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="student_email" placeholder="Student Email" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="student_password" placeholder="Password" class="w-full border p-2 rounded" required>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addStudentModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-red-600 text-white px-4 py-2 rounded">Add Student</button>
            </div>
        </form>
    </div>

    <!-- Edit Course Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center hidden">
        <form method="POST" class="bg-white p-6 rounded-lg w-96 space-y-4">
            <h2 class="text-xl font-semibold">Edit Course</h2>
            <input type="hidden" name="edit_course" value="1">
            <input type="hidden" name="course_id" id="edit_id">
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Class</label>
                <select name="class_id" id="edit_class_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <select name="subject_id" id="edit_subject_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Instructor</label>
                <select name="instructor_id" id="edit_instructor_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Instructor</option>
                    <?php foreach ($instructors as $instructor): ?>
                        <option value="<?= $instructor['id'] ?>"><?= htmlspecialchars($instructor['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="edit_title" class="w-full border p-2 rounded" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="edit_description" class="w-full border p-2 rounded" required></textarea>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>

    <!-- JS to handle modals and dynamic subject loading -->
    <script>
        function openEditModal(course) {
            document.getElementById('edit_id').value = course.id;
            document.getElementById('edit_class_id').value = course.class_id;
            document.getElementById('edit_subject_id').value = course.subject_id;
            document.getElementById('edit_instructor_id').value = course.instructor_id;
            document.getElementById('edit_title').value = course.title;
            document.getElementById('edit_description').value = course.description;
            document.getElementById('editModal').classList.remove('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
            }
        }

        // Dynamic subject loading based on class selection
        $(document).ready(function() {
            $('select[name="class_id"]').change(function() {
                var classId = $(this).val();
                if (classId) {
                    $.ajax({
                        url: 'get_subjects.php',
                        type: 'POST',
                        data: {class_id: classId},
                        success: function(data) {
                            $('select[name="subject_id"]').html(data);
                        }
                    });
                } else {
                    $('select[name="subject_id"]').html('<option value="">Select Subject</option>');
                }
            });
        });
    </script>
</body>
</html>