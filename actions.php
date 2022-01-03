<?php

include_once 'config.php';

global $db;

$requestbody = file_get_contents('php://input');
$data = json_decode($requestbody, true);

$action = (isset($_POST['action'])) ? $_POST['action'] : $data['action'];

switch ($action) {
    case 'add_task':
        addTask();
        break;

    case 'update_task':
        updateTask($data);
        break;
    
    default:
        # code...
        break;
}

function addTask(): void
{
    global $db;

    if (!isset($_POST['taskName'])) {
        return;
    }

    $db->addTask($_POST['taskName']);

    echo json_encode([
        'code' => 'ADD_TASK_OK',
        'taskID' => $db->getDatabase()->lastInsertRowID(),
        'taskName' => $_POST['taskName']
    ]);
}

function updateTask(array $data): void
{
    global $db;

    if (!isset($data['taskId'], $data['done'])) {
        return;
    }
    
    $db->updateTask(intval($data['taskId']), intval($data['done']));

    echo json_encode([
        'code' => 'UPDATE_TASK_OK',
    ]);
}
