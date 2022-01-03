const formAddTask = document.getElementById('#formAddTask');

const URL_ACTIONS = 'actions.php';

formAddTask.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    await fetch(URL_ACTIONS, {
            method: 'POST',
            body: formData
        })
        .then(data => data.json())
        .then(json => {
            if (json.code !== 'ADD_TASK_OK') return;
        })
})