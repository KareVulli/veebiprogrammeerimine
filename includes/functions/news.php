<?php

require_once(__DIR__ . '/../functions.php');

function saveNews($title, $content, $expire, $user_id)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpnews (title, content, expire, user_id) VALUES (:title, :content, :expire, :user_id)');
    return $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':expire' => $expire,
        ':user_id' => $user_id
    ]);
}



function getNews()
{
    $db = getDb();
    $stmt = $db->query(
        'SELECT n.id, n.title, n.content, n.created, n.expire, u.firstname, u.lastname ' .
        'FROM vpnews n ' .
        'LEFT JOIN vpusers u ON u.id = n.user_id ' .
        'WHERE n.expire >= CURDATE() ' .
        'ORDER BY n.created DESC'
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}