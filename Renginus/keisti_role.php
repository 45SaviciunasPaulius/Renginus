<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['user_id'], $_POST['new_role']) && $_POST["action"] === 'change_role') {
    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['new_role'];

    if (in_array($new_role, ['admin', 'vartotojas'])) {
        $stmt = $conn->prepare("UPDATE vartotojai SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $new_role, $user_id);
        $stmt->execute();
    }
}


if (isset($_POST['user_id'], $_POST['new_role']) && $_POST["action"] === 'delete_user') {
    $user_id = intval($_POST['user_id']);
    $stmt = $conn->prepare("DELETE FROM vartotojai WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}


header("Location: vartotojo_profilis.php");
exit();



?>