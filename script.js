const formAddTask = document.querySelector('#formAddTask');
const tableTask = document.querySelector('.table');
const inputTask = document.querySelector('#inputTaskName');
const checkboxes = document.querySelectorAll('.form-check-input');

const URL_ACTIONS = 'actions.php';

const updateTask = async function (e) {
    await fetch(URL_ACTIONS, {
        method: 'PUT',
        body: JSON.stringify({
            action: 'update_task',
            done: this.checked,
            taskId: this.dataset.id
        })
    });
}

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateTask);
});

formAddTask.addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    await fetch(URL_ACTIONS, {
            method: 'POST',
            body: formData
        })
        .then(data => data.json())
        .then(json => {
            if (json.code !== 'ADD_TASK_OK') return;

            const row = tableTask.insertRow();
            const firstCell = row.insertCell();
            const secondCell = row.insertCell();

            firstCell.classList.add('text-center');

            const checkbox = document.createElement('input');
            const taskName = document.createTextNode(json.taskName);

            checkbox.type = 'checkbox';
            checkbox.addEventListener('change', updateTask);
            checkbox.classList.add('form-check-input');
            checkbox.dataset.id = json.taskId;

            firstCell.appendChild(checkbox);
            secondCell.appendChild(taskName);

            inputTask.value = '';
        })
})