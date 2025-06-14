# 📝 To-Do List Web Application  

A **full-stack** to-do list application with user authentication, task management, and priority sorting. Built with PHP, MySQL, and JavaScript.

## ✨ Key Features  
- 🔒 **User Authentication**: Secure login/registration with password hashing  
- ✅ **Task Management**: Add, complete, and delete tasks  
- 🗓️ **Due Dates & Priorities**: Organize tasks by deadline and urgency (Low/Medium/High)  
- 📱 **Responsive Design**: Works on desktop and mobile devices  
- 🔄 **Real-time Updates**: Dynamic UI without page reloads (AJAX/Fetch API)  

## 🛠️ Tech Stack  
| Frontend          | Backend       | Database  |  
|-------------------|---------------|-----------|  
| HTML5/CSS3        | PHP           | MySQL     |  
| JavaScript (ES6)  | PDO/Sessions  |           |  

## 🚀 Installation  
1. **Prerequisites**:  
   - PHP 7.4+  
   - MySQL 5.7+  
   - Web server (Apache)  

2. **Database Setup**:  
   ```sql
   CREATE DATABASE todo_list;
   USE todo_list;
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       email VARCHAR(255) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL
   );
   CREATE TABLE tasks (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       title VARCHAR(255) NOT NULL,
       description TEXT,
       due_date DATE,
       priority ENUM('low', 'medium', 'high'),
       completed BOOLEAN DEFAULT 0,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id)
   );


   ## 📸 Screenshots

Here are a few screenshots of the application in action:

![Login](https://github.com/ibtissam058/ToDo-List/blob/main/Screenshots/Screenshot%202025-05-25%20222131.png?raw=true)
![Signup](https://github.com/ibtissam058/ToDo-List/blob/main/Screenshots/Screenshot%202025-05-25%20222423.png?raw=true)
![Main Page](https://github.com/ibtissam058/ToDo-List/blob/main/Screenshots/Screenshot%202025-05-25%20222655.png?raw=true)
![Add task](https://github.com/ibtissam058/ToDo-List/blob/main/Screenshots/Screenshot%202025-05-25%20230305.png?raw=true)
![Marked as complete](https://github.com/ibtissam058/ToDo-List/blob/main/Screenshots/Screenshot%202025-05-25%20230317.png?raw=true)
