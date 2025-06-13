<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_list";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'complete') {
                $task_id = $_POST['task_id'] ?? 0;
                $stmt = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = :task_id AND user_id = :user_id");
                $stmt->execute(['task_id' => $task_id, 'user_id' => $_SESSION['user_id']]);
                echo json_encode(['success' => true, 'message' => 'Task marked as complete']);
            } elseif ($_POST['action'] === 'delete') {
                $task_id = $_POST['task_id'] ?? 0;
                $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id");
                $stmt->execute(['task_id' => $task_id, 'user_id' => $_SESSION['user_id']]);
                echo json_encode(['success' => true, 'message' => 'Task deleted']);
            }
        } else {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $due_date = $_POST['due_date'] ?? null;
            $priority = $_POST['priority'] ?? '';
            $user_id = $_SESSION['user_id'];

            if (empty($title) || empty($priority)) {
                echo json_encode(['success' => false, 'message' => 'Title and priority are required']);
                exit();
            }

            $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority, completed) VALUES (:user_id, :title, :description, :due_date, :priority, 0)");
            $stmt->execute([
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'due_date' => $due_date,
                'priority' => $priority
            ]);

            echo json_encode(['success' => true, 'message' => 'Task added successfully']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $user_id]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'tasks' => $tasks]);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>