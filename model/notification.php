<?php
require_once 'pdo.php';
function add_notification($user_id, $content)
{
    $sql = "INSERT INTO notification (Recipient, content, Time) VALUES (?, ?, NOW())";
    pdo_execute($sql, $user_id, $content);
}
function get_recent_notifications($user_id)
{
    $sql = "SELECT * FROM notification WHERE Recipient = ? ORDER BY Time DESC LIMIT 10";
    return pdo_query($sql, $user_id);
}
function get_recent_notifications_with_zero_recipient()
{
    $sql = "SELECT * FROM notification WHERE Recipient = 0 ORDER BY Time DESC LIMIT 10";
    return pdo_query($sql);
}