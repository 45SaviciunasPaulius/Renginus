<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['renginys_id']) && isset($_POST['action'])) {
    $id = intval($_POST['renginys_id']);
    $action = $_POST['action'];

    if (in_array($action, ['approve', 'reject'])) {
        $new_status = $action === 'approve' ? 'approved' : 'rejected';
        $stmt = $conn->prepare("UPDATE renginys SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $id);
        $stmt->execute();
    }
}

header("Location: vartotojo_profilis.php");
exit();
