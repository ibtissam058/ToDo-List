<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>TASKS</title>
        <link rel="shortcut icon" href="../IBP-2/pictures/list_icon.png">
        <link rel="stylesheet" href="style1.css">
</head>
<body class="standard">
    <nav class="right">
        <a href="./logout.php" class="logout-button">
           <i class="fa-solid fa-right-from-bracket" style="color: #915f36;"></i></a>
    </nav>
    <div id="header">
        <h1 id="title">Just do it.<div id="border"></div></h1>
    </div>
    <div id="form">
        <form id="task_form">
            <input type="text" name="title" placeholder="Task Title" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="date" name="due_date">
            <select name="priority" required>
                <option value="">Select Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <button type="submit" name="Add_task">Add Task</button>
        </form>
    </div>
    <div class="todo-list">
        <div id="loading-tasks" style="display: none;">Loading tasks...</div>
        <ul class="todo-list"></ul>
    </div>
    <script src="main.js" type="text/javascript"></script>
</body>
</html>
