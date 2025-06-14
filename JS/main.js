document.addEventListener('DOMContentLoaded', function() {
    const taskForm = document.getElementById('task_form');
    const taskList = document.querySelector('.todo-list');
    const loadingTasks = document.getElementById('loading-tasks');

    loadTasks();
  
    taskForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(taskForm);
        fetch('add_task.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                taskForm.reset();
                loadTasks();
                alert('Task added successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the task');
        });
    });
    function loadTasks() {
        loadingTasks.style.display = 'block';
        taskList.innerHTML = '';
        fetch('add_task.php')
            .then(response => response.json())
            .then(data => {
                loadingTasks.style.display = 'none';
                if (data.success && data.tasks.length > 0) {
                    data.tasks.forEach(task => {
                        const li = document.createElement('li');
                        li.className = 'task-box';
                        li.innerHTML = `
                            <div class="task-content">
                                <strong ${task.completed ? 'class="completed"' : ''}>${task.title}</strong>
                                <p>${task.description || 'No description'}</p>
                                <p>Due: ${task.due_date || 'No due date'}</p>
                                <p>Priority: ${task.priority}</p>
                            </div>
                            <div class="task-actions">
                                ${task.completed ? '' : `<button class="complete-btn" data-id="${task.id}">Complete</button>`}
                                <button class="delete-btn" data-id="${task.id}">Delete</button>
                            </div>
                        `;
                        taskList.appendChild(li);
                    });
                    document.querySelectorAll('.complete-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const taskId = this.getAttribute('data-id');
                            updateTask(taskId, 'complete');
                        });
                    });
                    document.querySelectorAll('.delete-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const taskId = this.getAttribute('data-id');
                            updateTask(taskId, 'delete');
                        });
                    });
                } else {
                    taskList.innerHTML = '<li>No tasks found</li>';
                }
            })
            .catch(error => {
                loadingTasks.style.display = 'none';
                console.error('Error:', error);
                taskList.innerHTML = '<li>Error loading tasks</li>';
            });
    }
    function updateTask(taskId, action) {
        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('action', action);
        fetch('add_task.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTasks();
                alert(action === 'complete' ? 'Task marked as complete!' : 'Task deleted!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the task');
        });
    }
});
