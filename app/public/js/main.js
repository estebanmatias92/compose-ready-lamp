document.getElementById('task-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;

    fetch('index.php', {
        method: 'POST',
        body: JSON.stringify({ title: title, description: description }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadTasks();
    });
});

function loadTasks() {
    // Aquí puedes agregar la lógica para solicitar y mostrar las tareas existentes.
    // Por ejemplo, usando fetch para hacer una solicitud GET al backend.
}

document.addEventListener('DOMContentLoaded', loadTasks);
