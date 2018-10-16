<?php

require_once(__DIR__ . '/../functions.php');

function saveMessage($message)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpamsg (message) VALUES (:message)');
    return $stmt->execute([
        ':message' => $message
    ]);
}

function getMessages($notValidated = false)
{
    $db = getDb();
    if ($notValidated) {
        $stmt = $db->query('SELECT id, message, created, accepted FROM vpamsg WHERE accepted <> 1 ORDER BY created DESC');
    } else {
        $stmt = $db->query('SELECT id, message, created, accepted FROM vpamsg WHERE accepted = 1 ORDER BY created DESC');
    }
    return $stmt->fetchAll();
}

function getMessagesByValidaters()
{
    
    $db = getDb();
    $stmt = $db->query('SELECT m.id, m.message, m.created, m.accepted_at, m.accepted_by, u.firstname, u.lastname
                        FROM vpamsg m
                        LEFT JOIN vpusers u ON m.accepted_by = u.id
                        WHERE accepted = 1
                        ORDER BY m.accepted_by ASC, m.created DESC');
    $users = [];
    $lastUser = null;
    $messages = [];
    while ($row = $stmt->fetch()) {
        if ($lastUser != $row['accepted_by']) {
            if (count($messages)) { // If the user has validated any messages (This is not called only the first time around)
                $user['messages'] = $messages;
                $users[] = $user;
            }
            $lastUser = $row['accepted_by'];
            $user = []; // Clear the user variable (Just in case)
            // Fill in new user
            $user['id'] = $row['accepted_by'];
            $user['name'] = $row['firstname'] . ' ' . $row['lastname'];
            $messages = []; // Clear message array
        }
        $message['id'] = $row['id'];
        $message['message'] = $row['message'];
        $message['created'] = $row['created'];
        $message['accepted_at'] = $row['accepted_at'];
        $messages[] = $message;
    }
    // Add the last messages aswell
    $user['messages'] = $messages;
    $users[] = $user;
    return $users;
}

function setMessageValidated($id)
{
    $db = getDb();
    $user = getUser($_SESSION['user']);
    // We're setting the message as accepted and we also add information about who and when accepted the message
    // Where selecting what message to udpdate by filtering the messages by id. ID is unique to every message so there will be
    // Either 0 or 1 results. However even if there is 0 results, there is no error and that's fine. We don't need to care about that.
    // We do care about the validity of the user_id (specially if you have foreign key constrains properly set up). 
    $stmt = $db->prepare('UPDATE vpamsg SET accepted = 1, accepted_by = :accepted_by, accepted_at = NOW() WHERE id = :id');
    // UPDATE table set column = new_value, column2 = new_value2, ... WHERE [same as select] id = 2
    $stmt->execute([
        ':id' => $id,
        ':accepted_by' => $user['id']
    ]);
}
