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
